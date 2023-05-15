<?php

namespace Ninja;

interface Website
{
	public function defaultRoute(): string;
	public function getController(string $controllerName): object;
}