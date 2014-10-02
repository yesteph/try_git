#!/bin/sh

set -e

salt-cloud -m cloud.profiles.d/platform.tpl -P --config-dir .
