<?php

namespace App\Library;

/**
 * Class Numeros
 * Escreve por extenso (português) um número indo-arábico.
 * 
 * @author Alan Freire - alan_freire@msn.com
 * @version 2.0
 * @copyright MIT © 2016 - Alan Freire
 */
class Numeros
{
	/**
	 * @var integer
	 * @access private
	 *
	 * Número que será escrito por extenso
	 */
	private $numero;

	/**
	 * @var array
	 * @access private
	 *  
	 * Número separado por algarismos
	 */
	private $sequencia = array();

	/**
	 * Method __construct
	 * @access public
	 * 
	 * Recebe o número que será transformardo por parametro
	 * 
	 * @param integer
	 */
	public function __construct($numero = null)
	{
		if (!is_null($numero)) {
			$this->numero = $this->analisaNumero($numero);
		}
	}

	/**
	 * Method getNumero
	 * @access public
	 * 
	 * Retorna o número inserido
	 * 
	 * @return integer
	 */
	public function getNumero()
	{
		return $this->numero;
	}

	/**
	 * Method setNumero
	 * @access public
	 *
	 * Atribui um número para ser escrito por extenso
	 * 
	 * @param integer
	 * @return object
	 */
	public function setNumero($numero)
	{
		$this->numero = $this->analisaNumero($numero);

		return $this;
	}

	/**
	 * Method unidade
	 * @access private
	 * 
	 * Trata algarismo de unidade
	 * Recebe como parametro a posição do algarismo no array de algarismos
	 * 
	 * @param integer
	 * @return string
	 */
	private function unidade($chave)
	{
		$extenso = ['zero', 'um', 'dois', 'tres', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];	
		$extenso_10 = ['', 'onze', 'doze', 'treze', 'quatorze', 'quinze', 'dezesseis', 'desessete', 'dessoito', 'desenove'];

		if (isset($this->sequencia[$chave + 1])) {
			if ($this->sequencia[$chave + 1] == 1) {
				return (isset($this->sequencia[$chave + 2])? ' e ': '') . $extenso_10[$this->sequencia[$chave]];
			}

			if ($this->sequencia[$chave + 1] &&
				$this->sequencia[$chave] == 0 ||
				isset($this->sequencia[$chave + 2]) &&
				$this->sequencia[$chave + 2] == 1 &&
				$this->sequencia[$chave] == 0) {
				return;
			}
		}

		return (isset($this->sequencia[$chave + 1])? ' e ': '') . $extenso[$this->sequencia[$chave]];
	}

	/**
	 * Method dezena
	 * @access private
	 * 
	 * Trata algarismo de dezena
	 * Recebe como parametro a posição do algarismo no array de algarismos
	 * 
	 * @param integer
	 * @return string
	 */
	private function dezena($chave)
	{
		$extenso = ['', 'dez', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'];

		if ($this->sequencia[$chave] == 1 && $this->sequencia[$chave - 1] > 0 || $this->sequencia[$chave] == 0) {
			return;
		}

		return (isset($this->sequencia[$chave + 1])? ' e ': '') . $extenso[$this->sequencia[$chave]];
	}

	/**
	 * Method centena
	 * @access private
	 * 
	 * Trata algarismo de centena
	 * Recebe como parametro a posição do algarismo no array de algarismos
	 * 
	 * @param integer
	 * @return string
	 */
	private function centena($chave)
	{
		$extenso = ['', 'cem', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];

		if (!isset($this->sequencia[$chave]) || $chave < 0) {
			return;
		}

		if ($this->sequencia[$chave - 1] &&
			$this->sequencia[$chave - 2] &&
			$this->sequencia[$chave] == 1) {
			return isset($this->sequencia[$chave + 1])? ', cento': 'cento';
		}

		return (isset($this->sequencia[$chave + 1])? ', ': '') . $extenso[$this->sequencia[$chave]];
	}

	/**
	 * Method proExtenso
	 * @access public
	 * 
	 * Retorna o número passado por extenso
	 * @return string
	 */
	public function porExtenso()
	{
		$extenso = ['', 'mil', 'milhão', 'bilhão', 'trilhão', 'quatrilhão', 'quintilhão', 'sextilhão', 'septilhão', 'octilhão', 'nonilhão'];
		$extenso_p = ['', 'mil', 'milhões', 'bilhões', 'trilhões', 'quatrilhões', 'quintilhões', 'sextilhões', 'septilhões', 'octilhões', 'nonilhões'];

		$d = array_chunk($this->sequencia, 3);
		$s = [];
		$i = 0;
		$string = '';
		foreach ($d as $v) {
			switch (count($v)) {
				case 2:
					$s[] = $this->dezena($i + 1) . $this->unidade($i);
					break;

				case 1:
					$s[] = $this->unidade($i);
					break;
				
				default:					
					$s[] = $this->centena($i + 2) . $this->dezena($i + 1) . $this->unidade($i);
					break;
			}
			$i += 3;
		}
		$i = count($s) - 1;
		foreach(array_reverse($s) as $v) {
			if ($i == 0) {
				$string .= $v;
				break;
			}

			$string .= $v . ' ' . (array_sum($d[$i]) == 1? $extenso[$i--]: $extenso_p[$i--]);
		}

		return ucfirst(trim($string));
	}

	/**
	 * Method analisaNumero
	 * @access private
	 * 
	 * Recebe um valor por parametro e o trata,
	 * covertendo-o em inteiro e tornando-o positivo
	 * caso o mesmo não tenha essas caracteristicas
	 * 
	 * Separa o número em algarismo e os coloca em um array
	 * 
	 * @param mix
	 * @return integer
	 */
	private function analisaNumero($numero)
	{
		if (!is_integer($numero)) {
			$numero = (int) $numero;
		}

		if ($numero < 0) {
			$numero = $numero * (-1);
		}

		if ($numero == 0) {
			$this->sequencia[] = 0;
			return $numero;
		}

		for($tmp = $numero; $tmp >= 1;) {
			$this->sequencia[] = $tmp % 10;
			$tmp = (int) $tmp / 10;
		}

		return $numero;
	}
}