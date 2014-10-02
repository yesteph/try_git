#!/usr/bin/python

import argparse
import yaml
import salt
import commands
import subprocess

parser = argparse.ArgumentParser()
parser.add_argument("platform", help="name of the platform (*.yml file)",
                    type=str)
parser.add_argument("action", help="name of the action")
args = parser.parse_args()

platform_name=args.platform+".yml"
platform_folder="cloud.profiles.d/"
print "Load %s.tpl ....." % (platform_name)

topo = yaml.load(open(platform_folder+platform_name))

def infra_create():
  map={}
  for service in topo['services']:
    if service['type'] != 'ec2-vm':
      raise Exception("Service type %s not supported" %(service['type']))
    print "Process service : %s" % (service['service_name'])
    client = salt.cloud.CloudClient("/etc/salt/cloud")
    machines=[]
    for instance in service['instances']:
      name=instance
      provider=service['infra']['provider']
      kwargs=service['infra']
      stream = file('cloud.profiles.d/new-profile.conf', 'w')
      yaml.dump({name : kwargs}, stream)
      stream.close()
      machines.append(name)

    map[service['service_name']]=machines
    stream2 = file('cloud.profiles.d/map.tpl', 'w')
    yaml.dump(map, stream2)
    stream2.close()
   
    subprocess.call(['salt-cloud','-m','cloud.profiles.d/map.tpl','-P','--config-dir','.'])

eval(args.action)()
