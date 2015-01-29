<?php namespace Shiyanlou\Notification;

use Illuminate\Session\Store as SessionStore;

class Notification {
	private $session = null;

	public function __construct(SessionStore $session)
	{
		$this->session = $session;
	}

	private function addMessage($type, $content)
	{
		$this->session->put('notification_message', '<div class="am-alert ' . $type . '" data-am-alert><p></p>' . $content . '</div>');
	}

	public function primary($content)
	{
		$this->addMessage('am-alert-primary', $content);
	}

	public function secondary($content)
	{
		$this->addMessage('am-alert-secondary', $content);
	}

	public function success($content)
	{
		$this->addMessage('am-alert-success', $content);
	}

	public function warning($content)
	{
		$this->addMessage('am-alert-warning', $content);
	}

	public function danger($content)
	{
		$this->addMessage('am-alert-danger', $content);
	}

	public function show()
	{
		echo $this->session->pull('notification_message', '');
	}
}