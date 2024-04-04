#!/bin/bash

# Input PlantUML file
UML_FILE="$1"

# Directory where the image will be saved
IMG_DIR="imgs"

# Check if the input file exists
if [ ! -f "$UML_FILE" ]; then
    echo "Input file does not exist."
    exit 1
fi

# Check if PlantUML is installed
if ! command -v plantuml &> /dev/null; then
    echo "PlantUML is not installed. Please install it first."
    exit 1
fi

# Check if /imgs directory exists
if [ ! -d "$IMG_DIR" ]; then
    echo "Directory $IMG_DIR does not exist. Creating it now."
    mkdir -p "$IMG_DIR"
fi

# Generate PNG from UML
plantuml -tpng "$UML_FILE" -o "$IMG_DIR"

# Check if the PNG was created successfully
PNG_FILE="${IMG_DIR}/$(basename "${UML_FILE%.*}").png"
if [ -f "$PNG_FILE" ]; then
    echo "PNG created successfully at $PNG_FILE"
else
    echo "Failed to create PNG."
    exit 1
fi