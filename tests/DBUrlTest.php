<?php


class DBUrlTest extends Tipsy_Test {

	public function setUp() {
		$this->tip = new Tipsy\Tipsy;
		$this->useOb = true; // for debug use

		$this->tip->config('tests/config.ini');
		$env = getenv('TRAVIS') ? 'travis' : 'local';
		$this->tip->config('tests/config.db.'.$env.'.ini');

		$url = 'mysql://'.$this->tip->config()['user'].($this->tip->config()['pass'] ? ':'.$this->tip->config()['pass'] : '').'@'.$this->tip->config()['host'].'/'.$this->tip->config()['database'].'?persistent=true&something=else';

		// rebuild
		$this->tip = new Tipsy\Tipsy;
		$this->tip->config('tests/config.ini');
		$this->tip->config([db => [url => $url]]);
	}

	public function testDbUrl() {
		$catch = false;
		try {
			$res = $this->tip->db()->query('select now()');
			foreach ($res as $r) {
			}
		} catch (Excepction $e) {
			$catch = true;
		}
		$this->assertFalse($catch);
	}

	public function testDbFail() {
		$this->tip = new Tipsy\Tipsy;

		$catch = false;
		try {
			$res = $this->tip->db()->query('select now()');
			foreach ($res as $r) {
			}
		} catch (Exception $e) {
			$catch = true;
		}
		$this->assertTrue($catch);
	}
}