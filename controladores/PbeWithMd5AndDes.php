<?php

class PbeWithMd5AndDes
{
   /**
    * "Magic" keyword used by OpenSSL to put at the beginning of the encrypted
    * bytes.
    */
    private static $MAGIC_SALTED_BYTES = "Salted__";

    private static function _getCharRandonSalt($length = 16)
    {
        $salt = '';
	for ($n = 0; $n < $length; $n++)
	    $salt .= dechex(mt_rand(0, 0xF));
  
	return $salt;
    }

    public static function encrypt($data, $keystring, $salt = null, 
		$iterationsMd5 = 1, $segments = 1)
    {
        $useRandomSalt = false;
        if ($salt === null)
	{
	    $salt = PbeWithMd5AndDes::_getCharRandonSalt();
	    $useRandomSalt = true;
	    /**
	     * Number of iterations -
	     *  needs to be set to 1 for our roundtrip to work.
	     */
	    $iterationsMd5 = 1;
        }

        $pkcsKeyGenerator = new PkcsKeyGenerator(
			$keystring, $salt, $iterationsMd5, $segments);
		
        $encryptor = new DesEncryptor(
			$pkcsKeyGenerator->getKey(), $pkcsKeyGenerator->getIv());
		
        $crypt = $encryptor->transformFinalBlock($data);

	if ($useRandomSalt) {

          $n = strlen($salt);
          $sbin="";
          $i=0;
          while($i<$n)
          {
            $a =substr($salt,$i,2);
            $c = pack("H*",$a);
            if ($i==0){$sbin=$c;}
            else {$sbin.=$c;}
            $i+=2;
          }

	  // add the magic keyword, salt informazionr and encrypted byte
	  $crypt =  PbeWithMd5AndDes::$MAGIC_SALTED_BYTES .
	    $sbin .
	    $crypt;
	}

	// base64 encode so we can send it around as a string
	return base64_encode($crypt);
    }

    public static function decrypt($data, $keystring, $salt = null,
		$iterationsMd5 = 1, $segments = 1)
    {
        if ($salt === null)
	{
	    // get the salt information from the input
	    $salt = bin2hex(substr(base64_decode($data), 8, 8));

	    $data = base64_encode(substr(base64_decode($data), 16));

	    /**
	     * Number of iterations -
	     *  needs to be set to 1 for our roundtrip to work.
	     */
	    $iterationsMd5 = 1;
	}

        $pkcsKeyGenerator = new PkcsKeyGenerator(
			$keystring, $salt, $iterationsMd5, $segments);

        $encryptor = new DesEncryptor(
			$pkcsKeyGenerator->getKey(), $pkcsKeyGenerator->getIv(), false);

        return $encryptor->transformFinalBlock(base64_decode($data));
    }
}
