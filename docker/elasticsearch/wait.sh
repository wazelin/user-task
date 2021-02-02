#!/usr/bin/env sh

set -e

echo ">> Waiting for Elasticsearch to start"
WAIT=0
until docker-compose exec elasticsearch curl --output /dev/null --silent --head --fail localhost:9200 ; do
  sleep 1
  echo "   Elasticsearch not ready yet"
  WAIT=$((WAIT + 1))
  if [ "$WAIT" -gt 20 ]; then
    echo "Error: Timeout when waiting for Elasticsearch"
    exit 1
  fi
done

echo ">> Elasticsearch available, resuming command execution"

"$@"
