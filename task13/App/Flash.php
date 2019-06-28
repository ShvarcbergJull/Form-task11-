<?php
class Flash{
	protected $ss = false;
    protected function start_session()
    {
        if (!$this->ss)
        {
            session_start();
            $this->ss = true;
        }
    }
	public function set($m){
		$this->start_session();
		$_SESSION['fm']=$m;
	}
	public function get(){
		$this->start_session();
		$m=$_SESSION['fm'];
		return $m;
	}
	  public function del(){
        $this->start_session();
        if ( ! empty($_SESSION['fm'])){
            unset($_SESSION['fm']);
        }
    }
}
