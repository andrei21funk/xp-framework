<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('security.checksum.MessageDigest');

  /**
   * Checksum
   *
   * Usage [Getting an MD5 checksum from a string]
   * <code>
   *   $md5= MD5::fromString('Hello world');
   *   var_dump($md5->getValue());
   * </code>
   *
   * Usage [Getting an SHA1 checksum from a file]
   * <code>
   *   $sha1= SHA1::fromFile(new File('dummy'));
   *   var_dump($sha1->getValue());
   * </code>
   *
   * Usage [Verifying a CRC32 against a file]
   * <code>
   *   $crc32= new CRC32(1140816021);
   *   if (!$crc32->verify(CRC32::fromFile(new File('verify.me')))) {
   *     echo 'Verify failed';
   *   } else {
   *     echo 'Verify OK';
   *   }
   * </code>
   *
   * @purpose  Abstract base class to all other checksums
   */
  class Checksum extends Object {
    public $value = '';
      
    /**
     * Constructor
     *
     * @param   var value
     */
    public function __construct($value) {
      $this->value= (string)$value;
    }
  
    /**
     * Create a new checksum from a string. Override this
     * method in child classes!
     *
     * @param   string str
     * @return  security.checksum.Checksum
     */
    public static function fromString($str) { }

    /**
     * Returns message digest. Override this method in child classes!
     *
     * @return  security.checksum.MessageDigestImpl
     */
    public static function digest() { }

    /**
     * Create a new checksum from a file object. Override this
     * method in child classes!
     *
     * @param   io.File file
     * @return  security.checksum.Checksum
     */
    public static function fromFile($file) { }
    
    /**
     * Retrieve the checksum's value
     *
     * @return  var value
     */
    public function getValue() {
      return $this->value;
    }
  
    /**
     * Verify this checksum against another checksum
     *
     * @param   security.checksum.Checksum sum
     * @return  bool TRUE if these checksums match
     */
    public function verify(self $sum) {
      return $this->value === $sum->value;
    }

    /**
     * Check whether another object is equal to this
     *
     * @param   lang.Generic cmp
     * @return  bool TRUE if these checksums match
     */
    public function equals($cmp) {
      return $cmp instanceof $this && $this->verify($cmp);
    }

    /**
     * Returns a hashcode for this object
     *
     * @return  string
     */
    public function hashCode() {
      return $this->value;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->value.')';
    }
  }
?>
