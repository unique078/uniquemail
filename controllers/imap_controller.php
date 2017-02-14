<?php

class imapController{
	public function getImapInbox()
	{
		require('controllers/database.php');

		global $date;
		global $email_message;
	
		$date = array();
		$id = $_GET['id'];

		$st = $db->prepare("SELECT email, mail_server, password FROM email_accounts WHERE id = :id");
		$st->bindValue(':id', $id);
		$st->execute();

		$result = $st->fetchAll();

		$email_account = $result[0][0];
		$mailserver = $result[0][1];
		$password = $result[0][2];

		$mb = imap_open("{".$mailserver."}", $email_account, $password );
//		$mailboxes = imap_list($mb, "{".$mailserver."}", '*');
//		var_dump($mailboxes);

		$messageCount = imap_num_msg($mb);
		for( $MID = 1; $MID <= $messageCount; $MID++ )
		{
			   $EmailHeaders = imap_headerinfo( $mb, $MID );
			   $Body = imap_fetchbody( $mb, $MID, 1 );

			   $date[$MID]['date'] = $EmailHeaders->date;
			   $date[$MID]['subject'] = $EmailHeaders->subject;
	   		   $date[$MID]['size'] = $EmailHeaders->Size;
	   		   $date[$MID]['timestamp'] = $EmailHeaders->udate;
	   		   $date[$MID]['message'] = $Body;
			 
			foreach($EmailHeaders->from as $from )
			{
			   $date[$MID]['from'] = $from->mailbox;
			   $date[$MID]['host'] = $from->host;
			}
		}

	imapController::storeImapInbox();
//	echo '<pre>', print_r($EmailHeaders), '<pre>';
	}

	public function getImapOutbox(){
		require('controllers/database.php');

		global $outbox;
		global $email_message;
	
		$outbox = array();
		$id = $_GET['id'];

		$st = $db->prepare("SELECT email, mail_server, password FROM email_accounts WHERE id = :id");
		$st->bindValue(':id', $id);
		$st->execute();

		$result = $st->fetchAll();

		$email_account = $result[0][0];
		$mailserver = $result[0][1];
		$password = $result[0][2];

		$mb = imap_open("{".$mailserver."}INBOX.Sent", $email_account, $password );

		$messageCount = imap_num_msg($mb);
		for( $MID = 1; $MID <= $messageCount; $MID++ )
		{
			   $EmailHeaders = imap_headerinfo( $mb, $MID );
			   $Body = imap_fetchbody( $mb, $MID, 1 );

			   $outbox[$MID]['date'] = $EmailHeaders->date;
			   $outbox[$MID]['receiver'] = $EmailHeaders->toaddress;
			   $outbox[$MID]['subject'] = $EmailHeaders->subject;
	   		   $outbox[$MID]['size'] = $EmailHeaders->Size;
	   		   $outbox[$MID]['timestamp'] = $EmailHeaders->udate;
	   		   $outbox[$MID]['message'] = $Body;
		}
	}

	protected function storeImapInbox()
	{
		require('controllers/database.php');
		
		global $date;
		$userid = 1;
		$emailid = 40;
		foreach($date as $key=>$waarde):
			$st = $db->prepare("INSERT INTO inbox(subject, message, sender, sender_email, date, size, user_id, email_id, timestamp) VALUES(:subject, :message, :sender, :sender_email, :date, :size, :user_id, :email_id, :timestamp)");

			$st->execute(array(
				':subject' => $date[$key]["subject"], 
				':message' => $date[$key]['message'],
				':sender' => 'test', 
				':sender_email' =>  'test', 
				':date' => $date[$key]['date'], 
				':size' => $date[$key]["size"], 
				':user_id' => $userid, 
				':email_id' => $emailid, 
				':timestamp' => $date[$key]["timestamp"]
				));
		endforeach;
	}
}

?>