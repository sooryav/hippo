#!/bin/bash

# Get the current directory of this file.
PROJECT_TOOL_DIR=$(readlink -f $(dirname ${BASH_SOURCE[0]}))

# Get the parent directory, which is the project directory.
PROJECT_DIR=$(readlink -f $(dirname ${PROJECT_TOOL_DIR}))

echo "Setting PROJECT_DIR to $PROJECT_DIR."
export PROJECT_DIR=$PROJECT_DIR

echo "Updating PATH to include $PROJECT_TOOL_DIR"
export PATH=$PATH:$PROJECT_TOOL_DIR

echo $PATH
