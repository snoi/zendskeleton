<?php
//module/Auth/src/SanAuth/Model/User.php
namespace Auth\Model;
 
use Zend\Form\Annotation;
 
/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("User")
 */
class User
{
    /**
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Username:"})
     * @Annotation\Attributes({"class":"kolom"})
     */
    public $username;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Required({"required":"true" })
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Options({"label":"Password:"})
     * @Annotation\Attributes({"class":"kolom"})
     */
    public $password;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Checkbox")
     * @Annotation\Options({"label":"Remember Me ?:"})
     * @Annotation\Attributes({"class":"kolom"})
     */
    public $rememberme;
     
    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Submit","class":"kolom"})
     */
    public $submit;
}