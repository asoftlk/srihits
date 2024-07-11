#!/usr/bin/env bash
set -e

source="${1}"
source2="${2}"
target="${3}"
misc_params=" -y"
cmd="-filter_complex overlay=(main_w-overlay_w+30):10 ${target}"
echo -e "Executing command:\nffmpeg ${misc_params} -i ${source} -i ${source2} ${cmd}"
ffmpeg ${misc_params} -i ${source} -i ${source2} ${cmd}

# Check if the FFmpeg command was successful
if [ $? -eq 0 ]; then
    echo "Watermark added successfully"
    exit 0
else
    echo "Error adding watermark"
    exit 1
fi