#!/bin/bash

LOG_FILE="/root/log_speedtest.txt"
CSV_FILE="/var/www/html/speedtest_results.csv"

# Check if jq and bc are installed
if ! command -v jq &>/dev/null || ! command -v bc &>/dev/null; then
    echo "Erro: jq e bc são necessários. Por favor, instale-os antes de executar o script."
    exit 1
fi


speedtest_result=$(speedtest --format=json)
result_url=$(echo "$speedtest_result" | jq -r '.result.url')

server=$(echo "$speedtest_result" | jq -r '.server.name')
idle_latency=$(echo "$speedtest_result" | jq -r '.ping.latency')
download=$(echo "$speedtest_result" | jq -r '.download.bandwidth')
upload=$(echo "$speedtest_result" | jq -r '.upload.bandwidth')
packet_loss=$(echo "$speedtest_result" | jq -r '.packetLoss')

# Convert for MB
download=$(printf "%.2f\n" $(echo "scale=2; $download / 125000" | bc))
upload=$(printf "%.2f\n" $(echo "scale=2; $upload / 125000" | bc))

if [ -z "$result_url" ]; then
    result_url=$(echo "$speedtest_result" | jq -r '.result.url')
fi

# Save in CSV
echo "$(date +"%Y-%m-%d %H:%M:%S"),$server,$idle_latency,$download MB,$upload MB,$packet_loss,$result_url" >> $CSV_FILE

# Log infos
echo "$(date +"%Y-%m-%d %H:%M:%S") - Speedtest executado: $speedtest_result" >> $LOG_FILE
