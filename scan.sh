#!/bin/bash
echo '=== 1. Checking ClamAV ==='
clamscan -V || echo 'ClamAV not installed'

echo '=== 2. Checking Storage for PHP files ==='
find /home/ppidkab/ppid_version2/storage -type f -name '*.php'

echo '=== 3. Checking public_html for PHP files ==='
find /home/ppidkab/public_html -type f -name '*.php'

echo '=== 4. Checking for Suspicious Code (eval, base64_decode, shell_exec, system) in project files ==='
find /home/ppidkab/ppid_version2 /home/ppidkab/public_html -path /home/ppidkab/ppid_version2/vendor -prune -o -type f -name '*.php' -exec grep -lHEi '(eval\(|base64_decode\(|shell_exec\(|system\()' {} +