#!/bin/bash

set -e
set -x

# ensure SSH agent has all keys
ssh-add ~/.ssh/id_rsa

# set up the infrastructure
cd terraform
terraform init
terraform apply -auto-approve

cd ../ansible
# pull the instance information from Terraform, and run the Ansible playbook against it to configure
TF_STATE=../terraform/ ansible-playbook "--inventory-file=$(which terraform-inventory)" provision.yml

echo "Success!"

cd ../terraform
terraform output
