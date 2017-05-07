<?php


namespace Contao;

/**
 * Class ModuleCompanyList
 *
 */
class ModuleCompanyList extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_company_list';


	public function generate() {   
	    if ($_SERVER['REQUEST_METHOD']=="POST" && \Environment::get('isAjaxRequest')) {
	       $this->myGenerateAjax();
	       exit;
	    }
	   return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{


		$result = $this->Database->prepare("SELECT * FROM tl_company")->execute();

		while($result->next()) {

			$strAddress = sprintf('%s, %s %s %s', $result->address, $result->postalcode, $result->city, 'germany');
	        $strAddress = urlencode($strAddress);
	        // Get the coordinates
	        $objRequest = new \Request();
	        $objRequest->send('http://maps.googleapis.com/maps/api/geocode/json?address=' . $strAddress . '&sensor=false');
	        // Request failed
	        if ($objRequest->hasError()) {
	            \System::log('Could not get coordinates for: ' . $strAddress . ' (' . $objRequest->response . ')', __METHOD__, TL_ERROR);
	        }else{
	        	$objResponse = json_decode($objRequest->response);
				$this->Database->prepare("UPDATE tl_company SET lat=?, lng=? WHERE id=?")
               ->execute($objResponse->results[0]->geometry->location->lat, $objResponse->results[0]->geometry->location->lng,$result->id);
	        }
		}
		$objTemplate = new FrontendTemplate($this->custom_template);
		$this->Template->output = $objTemplate->parse();
	}

	
	public function myGenerateAjax()
	{      
	    // Ajax Requests verarbeiten
	    if(\Environment::get('isAjaxRequest')) {


	    	$result = $this->Database->prepare("SELECT * FROM tl_company")->execute();

			while($result->next())
			{
				$companylist[]['name'] = $result->title;
	  			$companylist[]['address'] = $result->address;
	  			$companylist[]['postalcode'] = $result->postalcode;
	  			$companylist[]['city'] = $result->city;
	  			$companylist[]['telephone'] = $result->telephone;
	  			$companylist[]['fax'] = $result->fax;
	  			$companylist[]['url'] = $result->url;
			}


	        header('Content-Type: application/json; charset=UTF-8');
	        echo json_encode($companylist);
	        exit;
	    }
	}


}