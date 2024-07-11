#!/usr/bin/env bash
set -e

source="${1}"
source2="${2}"
target="${3}"
misc_params=" -y"
cmd="-filter_complex overlay=main_w-(overlay_w+30):10 ${target}"
echo -e "Executing command:\nffmpeg ${misc_params} -i ${source} -i ${source2} ${cmd}"
ffmpeg ${misc_params} -i ${source} -i ${source2} ${cmd}