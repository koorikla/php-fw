variable "public_key_path" {
  default = "~/.ssh/id_rsa.pub"
}

variable "key_name" {
  default = "auth key"
}

variable "tags" {
  type = "map"
  default = {
    Repo = "https://github.com/startup-systems/terraform-ansible-example"
    Terraform = true
  }
}

