<?php


require $_SERVER['DOCUMENT_ROOT'] . '/model/Siswa.php';

class SiswaServices
{
	
	public function execute($params): void
	{
		//params
		$title = "Halaman Siswa";
		$siswas = $this->getSiswa();

		if (isset($params['edit'])) {
			$nis = $params['edit'];
			$dataSiswa = $this->getSiswa('WHERE nis ='.$nis); 
		}

		require_once $_SERVER['DOCUMENT_ROOT'] . '/views/siswa/indexSiswa.phtml';
	}

	private function getSiswa($where=null)
	{
		$siswa = new Siswa;

		if ($where != null) {
			$result = $siswa->con()->db()->prepare('SELECT * FROM siswa '.$where);
		} else {
			$result = $siswa->con()->db()->prepare('SELECT * FROM siswa');
		}
        $result->execute();
        $result = $result->fetchAll(PDO::FETCH_CLASS, 'Siswa');
        return $result;
	}

	public function postSiswa($params): void
	{
		$siswa = new Siswa;

		$result = $siswa->con()->db()->prepare('INSERT INTO siswa (nis, name, address, phone) VALUES (?,?,?,?)');
        $result->execute([$params['nis'],$params['name'], $params['address'], $params['phone']]);
        
        header("Content-Type: application/json");
		echo json_encode(['message' => 'success']);
	}

	public function updateSiswa($params): void
	{
		$siswa = new Siswa;

		$result = $siswa->con()->db()->prepare('UPDATE siswa SET name=?, address=?, phone=? WHERE nis=?');
        $result->execute([$params['name'], $params['address'], $params['phone'], $params['nis']]);
        
        header("Content-Type: application/json");
		echo json_encode(['message' => 'success']);
	}
}