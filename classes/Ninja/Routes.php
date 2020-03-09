<?php

namespace Ninja;

interface Routes {
	public function getRoutes(): array;
	public function getAuth(): \Ninja\Authentication;
}
