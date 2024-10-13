<?php
   ini_set('memory_limit', '25M');

	function getKey($password, $salt) {
		$key = hash_pbkdf2("sha1", $password, $salt, 100, 32, TRUE);
		return $key;
	}
	
	function decryptWithAes($cipherText, $key) {
		$iv = substr($cipherText, 0, 16);
		$encryptedText = substr($cipherText, 16);
		$data = openssl_decrypt($encryptedText, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
		
		if (ord($data[0]) == 1)
		{
			$signature = substr($data,1, 32);
			$content = substr($data, 32 + 1);
			$computedSignature = hash('sha256', $content, true);
			
			if ($signature != $computedSignature)
			{				
				echo "Corrupted data";
			}
			else
			{
				return $content;
			}
		}
		else
		{
			var_dump($data);
			echo "Corrupted data";
		}
		
		return null;
	}
	
	function encryptWithAes($plainText, $key) 
	{
		$iv = random_bytes(16);
		$sha256 = hash('sha256', $plainText, true);
		
		$contentToEncrypt = chr(1) . $sha256 . $plainText;
		$data = openssl_encrypt($contentToEncrypt, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
		return $iv . $data;
	}

	function crypte($input, $output)
	{
		$salt = hex2bin('0001020304050607');
		$pass= '1234Sygbuss.Yakoo5678';
		$inputContent = file_get_contents($input);
		$key = getKey($pass, $salt);
		$outputContent = encryptWithAes($inputContent, $key);
		file_put_contents($output, $outputContent);
	}

		function decrypte($input, $output)
	{
		$salt = hex2bin('0001020304050607');
		$pass= '1234Sygbuss.Yakoo5678';
		$inputContent = file_get_contents($input);
		$key = getKey($pass, $salt);
		$outputContent = decryptWithAes($inputContent, $key);
		file_put_contents($output, $outputContent);
	}

?>