#!/usr/bin/env sh

set -e

echo ">> Waiting for RabbitMQ to start"
WAIT=0
until docker-compose exec rabbitmq rabbitmq-diagnostics -q check_running ; do
  sleep 1
  echo "   RabbitMQ not ready yet"
  WAIT=$((WAIT + 1))
  if [ "$WAIT" -gt 20 ]; then
    echo "Error: Timeout when waiting for RabbitMQ"
    exit 1
  fi
done

echo ">> RabbitMQ available, resuming command execution"

"$@"
