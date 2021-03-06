<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\qrcode\formats;

use yii\base\InvalidConfigException;
use yii\validators\EmailValidator;

/**
 * Class vCard formats a string to properly create a vCard 4.0 QrCode
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\qrcode\formats
 */
class vCard extends FormatAbstract
{

    /**
     * @var string the name
     */
    public $name;
    /**
     * @var string the full name
     */
    public $fullName;
    /**
     * @var string the address
     */
    public $address;
    /**
     * @var string the nickname
     */
    public $nickName;
    /**
     * @var string the email
     */
    public $email;
    /**
     * @var string the work phone
     */
    public $workPhone;
    /**
     * @var string the home phone
     */
    public $homePhone;
    /**
     * @var string a date in the format YYYY-MM-DD or ISO 860
     */
    public $birthday;
    /**
     * @var string a date in the format YYYY-MM-DD or ISO 860
     */
    public $anniversary;
    /**
     * @var string the gender
     */
    public $gender;
    /**
     * @var string the categories. A list of "tags" that can be used to describe the object represented by this vCard.
     * e.g., developer,designer,climber,swimmer
     */
    public $categories;
    /**
     * @var string the instant messaging and presence protocol (instant messenger id)
     */
    public $impp;
    /**
     * @var string the photo
     */
    public $photo;
    /**
     * @var string the role e.g., Executive
     */
    public $role;
    /**
     * @var string the url
     */
    public $url;
    /**
     * @var string the name and optionally the unit(s) of the organization
     * associated with the vCard object. This property is based on the X.520 Organization Name
     * attribute and the X.520 Organization Unit attribute.
     */
    public $organization;
    /**
     * @var string notes
     */
    public $note;
    /**
     * @var string language of the user
     */
    public $lang;

    /**
     * @return string
     */
    public function getText()
    {
        $data[] = "BEGIN:VCARD";
        $data[] = "VERSION:4.0";
        $data[] = "N:{$this->name}";
        $data[] = "FN:{$this->fullName}";
        $data[] = "ADR:{$this->address}";
        $data[] = "NICKNAME:{$this->nickName}";
        $data[] = $this->getFormattedEmail();
        $data[] = "TEL;TYPE=WORK:{$this->workPhone}";
        $data[] = "TEL;TYPE=HOME:{$this->homePhone}";
        $data[] = "BDAY:{$this->birthday}";
        $data[] = "GENDER:{$this->gender}";
        $data[] = "IMPP:{$this->impp}";
        $data[] = $this->getFormattedPhoto();
        $data[] = "ROLE:{$this->role}";
        $data[] = "URL:{$this->url}";
        $data[] = "ORG:{$this->organization}";
        $data[] = "NOTE:{$this->note}";
        $data[] = "ORG:{$this->organization}";
        $data[] = "LANG:{$this->lang}";
        $data[] = "END:VCARD";

        return implode("\n", $data);
    }

    /**
     * @return string the formatted email. Makes sure is a well formed email address.
     * @throws \yii\base\InvalidConfigException
     */
    protected function getFormattedEmail()
    {
        $validator = new EmailValidator();
        if (!$validator->validate($this->email, $error)) {
            throw new InvalidConfigException($error);
        }

        return "EMAIL;TYPE=PREF,INTERNET:{$this->email}";
    }

    /**
     * @return string the formatted photo. Makes sure is of the right image extension.
     * @throws \yii\base\InvalidConfigException
     */
    protected function getFormattedPhoto()
    {
        $ext = strtolower(substr(strrchr($this->photo, '.'), 1));
        if ($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png' || $ext == 'gif')
            $ext = strtoupper($ext);
        else
            throw new InvalidConfigException('Invalid format Image!');

        return 'PHOTO;VALUE=URL;TYPE=' . $ext . ':' . $this->photo;
    }
}