#!/bin/bash

###
#
# This is a bash script which will set up the development environment for
# Laravel projects. This script assumes you are running the latest Ubuntu 16.04.
#
##
if [ $(whoami) != "root" ]; then
    echo "You must run this script as root."
    exit 1
fi
clear
echo "Assuming that Ubuntu 16.04 is the current system..."
echo "Installing a local version of php7.0..."
apt-get install php7.0-cli
echo "Installing php extensions..."
apt-get install php7.0-xml php7.0-mbstring
echo "Installing Laravel dependency..."
apt-get install composer
echo "Installation success! Enjoy your programming!"
echo "If you like this project, please star it on GitHub: https://github.com/TehTotalPwnage/DLEMP"
echo "If you'd like to support me, consider donating on Patreon: https://patreon.com/tehtotalpwnage"
