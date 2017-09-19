<?
/**
 * Heartland Portico Gateway ReportBatchSummary class.
 *
 * Class includes ReportBatchSummary functionality linked to SiteId and DeviceId supplied in the header
 * 
 * @author Michael Rice <rice.michaelt@gmail.com>
 * 
 * @copyright 2015 Michael Rice 
 * @license http://www.gnu.org/licenses/ GNU Lesser Public License (LGPL)
 *
 * @version 0.5.0
 *
 * This program is free software: you can redistribute it and/or modify  
 * it under the terms of the GNU Lesser Public License as published by  
 * the Free Software Foundation, either version 3 of the License, or  
 * (at your option) any later version.  
 *   
 * This program is distributed in the hope that it will be useful,  
 * but WITHOUT ANY WARRANTY; without even the implied warranty of  
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the  
 * GNU Lesser Public License for more details.  
 *   
 * You should have received a copy of the GNU Lesser Public License  
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.  
 *
 */
##*******************************************************************************************##
/**
 * ReportBatchSummary extends portico to return a batch's status information and totals broken down by payment type
 *
 * @package porticoAPI
 *
*/
class ReportBatchSummary extends portico{
	/**
	 * Array of required properties.
	 * 
	 * @var array
	 */
	protected $required = [
		'ReportBatchSummary' => []
	];
/*********************************************************************************************/
###############################################################################################
	/**
	 * Builds ReportBatchSummary request and submit it to portico::Transaction
	 *
	 * @return ReportBatchSummaryResponse|FailureResponse formatted response from Heartland SOAP interface
	 */
	public function doTransaction()
	{
		$this->initRequest();

		$this->setTransaction([
			'ReportBatchSummary' => []
		]);
		
		return $this->Transaction();
	}
}
##*******************************************************************************************##
/**
 * Heartland Portico ReportBatchSummaryResponse class
 *
 * Response object for ReportBatchSummary
 *
 * @package porticoAPI
 *
 */
class ReportBatchSummaryResponse extends porticoResponse{
	/**
	 * Summary for ReportBatchSummary response containing fields: 'BatchId','CreditCnt','CreditAmt',
	 * 'DebitCnt','DebitAmt','SaleCnt','SaleAmt','ReturnCnt','ReturnAmt','TotalCnt','TotalAmt','TotalGratuityAmtInfo'
	 * 
	 * @var array 
	 */
	var $Summary;
	/**
	 * Details for ReportBatchSummary response indexed by 'CardType' and contains multiple arrays of fields: 'CreditCnt',
	 * 'CreditAmt','DebitCnt','DebitAmt','SaleCnt','SaleAmt','ReturnCnt','ReturnAmt','TotalCnt','TotalAmt','TotalGratuityAmtInfo'
	 * 
	 * @var array 
	 */
	var $Details;
	/**
	 * Check response and builds formatted object.
	 *
	 * @param array $response Request array generated by portico and sent to Heartland Portico Gateway
	 * @param string $request Complete SOAP XML from Heartland Portico Gateway
	 */
	function __construct($response, $request = '')
	{
		parent::__construct($response, $request);
		
		$this->Summary = [
			'BatchId'              => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->BatchId,
			'CreditCnt'            => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->CreditCnt,
			'CreditAmt'            => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->CreditAmt,
			'DebitCnt'             => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->DebitCnt,
			'DebitAmt'             => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->DebitAmt,
			'SaleCnt'              => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->SaleCnt,
			'SaleAmt'              => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->SaleAmt,
			'ReturnCnt'            => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->ReturnCnt,
			'ReturnAmt'            => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->ReturnAmt,
			'TotalCnt'             => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->TotalCnt,
			'TotalAmt'             => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->TotalAmt,
			'TotalGratuityAmtInfo' => $response->{'Ver1.0'}->Transaction->ReportBatchSummary->Header->TotalGratuityAmtInfo
		];

		foreach($response->{'Ver1.0'}->Transaction->ReportBatchSummary->Details as $d)
		{
			$this->Details[$d->CardType][] = [
				'CreditCnt'            => $d->CreditCnt,
				'CreditAmt'            => $d->CreditAmt,
				'DebitCnt'             => $d->DebitCnt,
				'DebitAmt'             => $d->DebitAmt,
				'SaleCnt'              => $d->SaleCnt,
				'SaleAmt'              => $d->SaleAmt,
				'ReturnCnt'            => $d->ReturnCnt,
				'ReturnAmt'            => $d->ReturnAmt,
				'TotalCnt'             => $d->TotalCnt,
				'TotalAmt'             => $d->TotalAmt,
				'TotalGratuityAmtInfo' => $d->TotalGratuityAmtInfo
			];
		}

	}
}
?>