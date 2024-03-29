<?php

namespace Ninja;

class EntryPoint {
	private Website $webSite;

	public function __construct(Website $webSite) {
		$this->webSite = $webSite;
	}

	public function checkUri($uri)
	{
		if ($uri !== strtolower($uri)) {
			http_response_code(301);
			header('location: /' . strtolower($uri));
		}
	}

	private function loadTemplate($template, $variables = [])
	{
		extract($variables);

		ob_start();

		include __DIR__ . "/../templates/{$template}";

		return ob_get_clean();
	}

	public function run($uri, $requestMethod)
	{
		try {
			if ($uri == '') {
				$uri = $this->webSite->defaultRoute();
			}

			$this->checkUri($uri);

			$route = explode('/', $uri);

			$controllerName = array_shift($route);
			$action = array_shift($route);

			$controller = $this->webSite->getController($controllerName);

			if ($requestMethod === 'POST' && ! isset($_POST['id'])) {
				$action .= 'Submit';
			}

			$page = $controller->$action(...$route);

			$title = $page['title'];
			$variables = $page['variables'] ?? [];
			$output = $this->loadTemplate($page['template'], $variables);
		} catch (PDOException $e) {
			$title = "An error has ocurred";
			$output = sprintf("Database error: %s in %s:%s",
				$e->getMessage(),
				$e->getFile(),
				$e->getLine()
			);
		}

		include __DIR__ . '/../templates/layout.html.php';
	}
}