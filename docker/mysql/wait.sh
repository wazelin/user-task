#!/usr/bin/env sh

set -e

echo ">> Waiting for MySql to start"
WAIT=0
until docker-compose exec mysql mysqladmin ping -pdev | grep "mysqld is alive" ; do
  sleep 1
  echo "   MySql not ready yet"
  WAIT=$((WAIT + 1))
  if [ "$WAIT" -gt 20 ]; then
    echo "Error: Timeout when waiting for MySql socket"
    exit 1
  fi
done

echo ">> MySql socket available, resuming command execution"

"$@"
