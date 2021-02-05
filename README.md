# User Task
[![Build Status](https://travis-ci.com/wazelin/user-task.svg?branch=main)](https://travis-ci.com/wazelin/user-task)
> A simple CQRS and Event Sourcing demo application.

# Installation

## Installing the dependencies and starting the application
```shell
$ make start
```

## Preparing storage
```shell
$ make prepare-storage
```

## Stopping the application
```shell
$ make stop
```

# Documentation
[Open API](https://editor.swagger.io/?url=https://raw.githubusercontent.com/wazelin/user-task/main/public/openapi.yaml)

# Testing
```shell
$ make ci
```

# Replaying the events
```shell
$ make replay-events
```

# Out of scope
- Authentication
- Authorization
- Non-blocking event bus
