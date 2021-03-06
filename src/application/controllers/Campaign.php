<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Campaign extends MY_Controller
 {
  function __construct()
  {
   parent :: __construct();
   $this->load->model('User_model');   
   $this->load->model('Campaign_model');
   $this->data['ppr']=10;
  }

    public function show($campaign_url) {
        $campaign_id = $this->Campaign_model->GetCampaignIDByURL($campaign_url);

        $this->campaign_details($campaign_id);
    }

  public function campaign_details($campaign_id)
  {
   $this->data['campaign_id']=$campaign_id;	  
   $this->data['campaign_details']=$this->User_model->GetCampaignDetails($this->data['campaign_id']);
   $this->data['campaign_comments']=$this->User_model->GetCampaignComments($this->data['campaign_id']);
   // check user session
   $this->UserSessionCheckOnIndividualPage();
   $this->data['loggedin_user']=$this->session->userdata('site_username');
   $this->data['campaign_settings']=$this->User_model->getDefaultCampaignBanner();
   //$this->data['total_raised_amount']=$this->User_model->getRaisedAmountOfCampaign($this->data['campaign_id']);
   if($this->data['loggedin_user'] == $this->data['campaign_details']['username'])
   {
	$values=array();
    $caller=$this->input->post('caller'); 
    if($caller == "Send")
    {
     $values['comments']=$this->input->post('comments');
	 if($values['comments'] == 'Post an update about your campaign!') $values['comments']='';	
     $values['email_to_donors']=$this->input->post('email_to_donors');
	 $records=array();
	 $records['comments']=$values['comments'];
	 $records['campaign_id']=$this->data['campaign_id'];
	 
	 $this->User_model->InsertComment($records);
	
     if(($values['email_to_donors'] == 'yes') and !empty($values['comments']))
	 {
	  // Send Message to all donors of this campaign
	  $donor_emails=$this->User_model->getCampaignDonorsEmails($this->data['campaign_id']);
	  if(count($donor_emails) > 0)
	  {
	   $donor_email_ids=implode(",",$donor_emails);
	   
	   $this->SendMessageToAllDonors($records,$this->data['campaign_details'],$donor_email_ids);
	  }
	  $success_message="Your comment has been updated and email has been sent to your donors for this update successfully";
	 }
	 else $success_message="Your comment has been updated successfully";
	 //echo $success_message;
     //$this->RedirectPage('campaign/campaign-details/'.$this->data['campaign_id'], $success_message);
     
	 $this->RedirectPage($this->data['campaign_details']['url'], $success_message);
    }
	else $values['comments']='';
	$values['url']=$this->data['campaign_details']['url'];
	$this->data['attributes']=$this->User_model->getUserCommentFormAttributes($values); 
	//$this->websitejavascript->include_footer_js=array('SuccessMessageJs');
  
   } 
   
   
   $this->data['total_donations']=$this->User_model->GetAllDonationOfCampaign($this->data['campaign_id']);   

   if($this->data['total_donations'] > 0)
   {   
    
    $this->data['cp']=1;

    $this->data['pagination']=$this->commonfunctions->Pagenation($this->data['cp'], $this->data['ppr'],$this->data['total_donations']);
  
    $this->data['donations']=$this->User_model->GetAllDonationOfCampaign($this->data['campaign_id'],"limit ".$this->data['pagination']['start_limit'].",".   $this->data['pagination']['end_limit']);
   
   }
   
   $this->websitejavascript->include_footer_js=array('CampaignJs','SuccessMessageJs');
   
   $this->data['meta']=$this->Metatags_model->GetMetaTags('SINGLE_PAGE','31',$this->data['campaign_details']['campaign_name']);
   $this->data['cta']=$this->Website_model->GetCTAButtons('SINGLE_PAGE','31'); 
   $this->data['active_menu']="campaign";  
   $this->load->view('templates/header',$this->data);
   $this->load->view('campaign/campaign-details',$this->data);
   $this->load->view('templates/footer');
  }
  public function getMoreRecords()
  {
   $this->data['cp']=$this->input->post('cp');
   $this->data['campaign_id']=$this->input->post('campaign_id');
   
   $this->data['total_donations']=$this->User_model->GetAllDonationOfCampaign($this->data['campaign_id']);   

   if($this->data['total_donations'] > 0)
   {   
    $this->data['pagination']=$this->commonfunctions->Pagenation($this->data['cp'], $this->data['ppr'],$this->data['total_donations']);
    $this->data['donations']=$this->User_model->GetAllDonationOfCampaign($this->data['campaign_id'],"limit ".$this->data['pagination']['start_limit'].",".   $this->data['pagination']['end_limit']);

    $this->load->view('campaign/getDonationRecords',$this->data);
   }
  }
  public function deletecomment($campaign_url,$comment_id)
  {
   $this->User_model->DeleteComment($comment_id);  
   $success_message="Your comment has been deleted successfully";   
   $campaign_url=str_replace("_","-",$campaign_url);
   $this->RedirectPage($campaign_url, $success_message);
  }
  public function SendMessageToAllDonors($values,$campaign_details,$donor_email_ids)
  {
   // Mail to user	  
   $mailBody="<div style='clear:both;'></div>
   <div style='margin:0px; padding-top:15px; padding-bottom:15px;'>
    	<div style='float:left; width:200px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:12px; color:#000;'>Campaign Name:</div> <div style='float:left; width:440px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:12px; color:#4485fd;'>".$campaign_details['campaign_name']."</div>
		
     
      <div style='clear:both;'></div>
	  
    	<div style='float:left; width:200px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:12px;color:#000;'>Comments:</div><br /> <div style='float:left; width:440px; font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:12px;color:#000;'>".$values['comments']."</div>

     <div style='clear:both;'></div>
    <div style='clear:both;'></div></div>";	
	$mailto=array();
	$mailto['email']=$donor_email_ids;
	//$mailto['name']=$values['donor_name'];;
	 
   $this->SendMailToUser($mailBody,$mailto,11,$other_info=''); 
    
   
  }
 }
