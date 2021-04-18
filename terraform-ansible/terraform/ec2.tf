locals {
  # The default username for our AMI
  vm_user = "admin"
}

data "aws_ami" "debian" {
  most_recent = true

  filter {
    name   = "name"
    values = ["debian-10-amd64-*"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  owners = ["136693071363"]
}

resource "aws_key_pair" "auth" {
  key_name   = "${var.key_name}"
  public_key = "${file(var.public_key_path)}"
}

resource "aws_instance" "web" {
  instance_type = "t2.micro"
  tags = "${var.tags}"
  ami = "${data.aws_ami.debian.id}"
  depends_on = [aws_key_pair.auth]


  # The name of our SSH keypair
  key_name = "${var.key_name}"

  # Our Security group to allow HTTP and SSH access
  vpc_security_group_ids = ["${aws_security_group.default.id}"]

  subnet_id = "${aws_subnet.default.id}"

  # force Terraform to wait until a connection can be made, so that Ansible doesn't fail when trying to provision
  provisioner "remote-exec" {
    # The connection will use the local SSH agent for authentication
    inline = ["echo Successfully connected"]

    # The connection block tells our provisioner how to communicate with the resource (instance)
    connection {
      user = "${local.vm_user}"
      host = "${aws_instance.web.public_ip}"
      private_key = file("~/.ssh/id_rsa")

    }
  }
}


resource "aws_instance" "db-master" {
  instance_type = "t2.micro"
  tags = "${var.tags}"
  ami = "${data.aws_ami.debian.id}"
  depends_on = [aws_key_pair.auth]


  # The name of our SSH keypair
  key_name = "${var.key_name}"

  # Our Security group to allow HTTP and SSH access
  vpc_security_group_ids = ["${aws_security_group.default.id}"]

  subnet_id = "${aws_subnet.default.id}"

  # force Terraform to wait until a connection can be made, so that Ansible doesn't fail when trying to provision
  provisioner "remote-exec" {
    # The connection will use the local SSH agent for authentication
    inline = ["echo Successfully connected"]

    # The connection block tells our provisioner how to communicate with the resource (instance)
    connection {
      user = "${local.vm_user}"
      host = "${aws_instance.web.public_ip}"
      private_key = file("~/.ssh/id_rsa")

    }
  }
}



resource "aws_instance" "db-slave" {
  instance_type = "t2.micro"
  tags = "${var.tags}"
  ami = "${data.aws_ami.debian.id}"
  depends_on = [aws_key_pair.auth]


  # The name of our SSH keypair
  key_name = "${var.key_name}"

  # Our Security group to allow HTTP and SSH access
  vpc_security_group_ids = ["${aws_security_group.default.id}"]

  subnet_id = "${aws_subnet.default.id}"

  # force Terraform to wait until a connection can be made, so that Ansible doesn't fail when trying to provision
  provisioner "remote-exec" {
    # The connection will use the local SSH agent for authentication
    inline = ["echo Successfully connected"]

    # The connection block tells our provisioner how to communicate with the resource (instance)
    connection {
      user = "${local.vm_user}"
      host = "${aws_instance.web.public_ip}"
      private_key = file("~/.ssh/id_rsa")

    }
  }
}