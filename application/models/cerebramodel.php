<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Cerebramodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		{
			$this->load->database();
			$this->load->helper('url');
			$this->load->helper('date');

		}
	}
function initialize($kid){
		$q="SELECT kid from k13_cerebra where kid=?";
		$res=$this->db->query($q,$kid);
		if($res->num_rows()>0)
			return;
		else
		{//set initial value in database.
			$query1="Select fullname from bitauth_userdata where kid=?";
			$result1=$this->db->query($query1,$kid);
			foreach($result1->result() as $row1)
				$name=trim($row1->fullname);		
			$qid=array();
			for($u=0;$u<=40;$u++)
			$qid[$u]=$u;
			
			for($value=1;$value<count($qid);$value++) 
			{
			$this->db->insert('k13_cerebra',array('kid'=>$kid,'qid'=>$qid[$value],'attempt'=>0,'flag'=>0));
			}

		$this->db->insert('cerebra_users',array('kid'=>$kid,'name'=>$name,'points'=>0,'answered'=>0));	

			
			//fb post..
		}
	}

public function getques($kid)
{
	$q1="select points,answered from cerebra_users where kid=?";
	$r1= $this->db->query($q1,$kid);
	$rr1   = $r1->row();
	
	
		$q2    = "select qid,attempt,flag from k13_cerebra where kid=?";
		$r2    = $this->db->query($q2,$kid);
		$rr2   = $r2->row();
		$qid=array(0);
		foreach($r2->result() as $row)
			$qid[]=$row->qid;
		
		$qa=array(0);
		$qw=array(0);
		//$qa    = $rr2->flag;
		//$qw    = $rr2->attempt;
		foreach($r2->result() as $row)
			{
				$qa[]=$row->flag;
				$qw[] = $row->attempt;
			}
				$ques= array("dont touch me :P",

					"Harvey loves factors.He wants to find the largest factor of the number formed from his birthday 13/8/1992 (i.e 1381992)  which  should also be a prime. Can you answer his query ?",

"* Find the next term in the series:<br>

10^3, 10^9, 10^12, 10^2, 10^0, __<br>

Enter your answer in words. Eg. If your answer is 102, then enter as onehundred",

"If  there is only 2 digits 5 and 6 in Bagel’s number system.i.e 1st number is 5,2nd is 6 and so on such that number sequence is 5,6,55,56,65,66,555,... What is the 100th number ?",

"Vishnu takes a fair coin from his pocket and flips it once. His brother  flips a fair coin twice. Find the probability that vishnu obtains more heads than his brother ?
<br>
Answer in the form of a/b",

"*  Find the missing number(?) in the 3rd box

<br>
 <img src='http://localhost/ros/assets/images/first.png'/>
 <br>
 <img src='http://localhost/ros/assets/images/second.png'/>
 <br>
 <img src='http://localhost/ros/assets/images/third.png'/>",

"Ramu was travelling in a bus and there was a digital 24 hrs clock and a mirror next to it. Rather than looking directly at the clock, Ramu preferred looking the image of clock in the mirror. Initially the image showed him 10:55. He took a nap and after waking up he saw the mirror again. It showed him 85:20. Find the actual amount of time (in seconds) spent while sleeping.",

"64:6163 :: 58: ?",

"Two gears of diameter 5cm and 9.6cm respectively, are adjusted so that the smaller gear drives the larger one. If the smaller gear rotates through an angle of 225 degrees, through how many degrees, will the larger gear rotate?
<br>

(Input your answer to the nearest integer)",

"A little kid was playing with a container having 80 litres of milk. The kid had an 8 litre measuring jar and started to take out a jar full of milk from the container and poured a jar full of water instead. The kid repeated this further twice, before he was caught red-handed by this mother. How much litres of milk is available in the container now?",

"* If 1/4 of 20 is 6, then what is 1/6 of 10? (Format: Round off to 2 decimal places if needed)",

"A motor car travelling towards a lake overtakes a cyclist at 0900hrs. The car reaches the lake at 1030hrs and after waiting for an hour, returns, meeting the cyclist at noon (1200hrs). When will the cyclist reach the lake? (If he reaches at 1545hrs, answer format: 1545)",

"Use a standard cipher to decode the following message.<br>

HINT: A famous Personality<br>

Encrypted text:<br> kzfodzopvi",


"Harry Potter travelled a distance of 52km in 9 hours.He travelled partly on foot at 3km/hr and partly on broomstick at 8km/hr.The distance travelled on broomstick is:",  

"Sheldon is so bored that he started counting the number of digits used to represent the each page in the book he was reading. The pages are numbered in sequential order starting from 1.If the total number of decimal digits used is 189 can you find out the number of pages in the book ?",

"A woman sees the photograph of a man and says, “This sister of that man is my mother-in-law”. How is the man in the photograph related to the woman’s husband?",


"If<br> 1=5<br>

2=15<br>

3=35<br>

4=75<br>

5=?",

"Father Of Donna was 29 years of age when she was born while her mother was 26 years old when her sister four years younger to her was born. What is the difference between the ages of her parents?",

"P started a Restaurant with Rs 10000 as captial .5 months passed. Q then joined the company.At the end of the first year profit was divided in the ratio 1:7 .What is the capital of Q ?",

"There are 500 match sticks in hand. Your job is to pick certain number of sticks, which when divided by all the numbers from 2 to 8 except 5, will leave a whole number quotient and 0 remainder, when one match stick is removed before dividing. One more constraint is that  you have to pick a minimum of 200 match sticks. Find the number.",

"Sam bought a juice can worth Rs.100.The juice in it is worth 90 rupees more than the can.How much is the can worth(in rupees) ?",

"Three numbers are in Arithmetic Progression, three other numbers are in geometric progression. Adding the corresponding terms of these two progressions successively, we obtain 181,43 and 49 respectively and adding all the three terms in the arithmetic progression, we get 90. It is found that, the geometric progression has common ratio less than 1. Find the terms of both the progression. (FORMAT: three terms in A.P. followed by three terms in G.P. eg. If 1,2 and 3 are in A.P. and 50,10,2 are in G.P, then answer should be 12350102)",

"Decode the message<br>

   LITILDJRYTS

   <br>

  by just using your keyboard (Answer in lowercase without space)",

"A nuclear reaction projects an atomic particle along a straight line at 900 metres per second. After 5 seconds, a second particle is projected along the same path at a speed of 1200 metres per second. After how many seconds, will the second particle pass the first?",

"There were hundred switches numbered from 1 to 100 in a multi-storey building. All were initially in OFF state. A kid, who felt bored, plays with the switches. He starts from the 1st switch and flips the state of every adjacent switch. Then again, he starts from the 2nd switch and flips the state of every 2nd switch from there on. Likewise, if he started from nth switch, he would flip the state of every nth switch from there on. After n=100, how many switches will be turned ON?",

"If<br> 5=5

<br>8=1

<br>15=15

<br>20=5

<br>35=?",

"A 4X4X4 cube is broken down into smaller identical cubes of equal sizes 1X1X1. Before breaking down the cube, all the 6 faces of the larger cube were painted blue. After breaking down the cube, how many smaller cubes will have at least two faces painted, but not three faces painted?",

"* Each letter in the cryptarithm XYYXXY/ABCD=YX uniquely represents a digit in the decimal scale (0-9). What decimal digits do the letters X and A represent? (Format: decimal equivalent of X followed by decimal equivalent of A).",

"You have x candies that you want to share. You eat one, and then divide the leftover candies into two equal groups, and pass them on to two people. They each eat one, and do the same, and so on. It takes 1 minute to eat a candy, and 30 seconds to pass the candies from one person to the next. If all the candies are eaten in 7 minutes, how many candies were there to begin with?",

"Stephen has a physical balance and wants to measure chocolate packets of different weights. It is assured that, each chocolate bag’s weight is a natural number. He wants to buy weights for the balance. The maximum weight of a chocolate packet is 121kg. Find the minimum number of weights he should buy to weigh any packet of weight, not more than 121kg. (Eg. If he buys weights 2kg and 3kg, to weigh a chocolate pack of 1kg, he can place the 1kg pack along with 2kg weight on one side of the balance and 3kg weight on the other side and make sure that, the balance is in balanced state.)",

"Four boys and two girls are supposed to be seated in a row. The constraint is that, the two girls cannot sit together. How many such seating arrangements are possible?",


"Mohan is always fond of Math Puzzles. He used to solve many such puzzles and ask the same to his dad. On a fine Sunday, Mohan was stuck with a puzzle and asked for his dad’s help. Brilliant dad cracked the puzzle and explained him how to solve such puzzles. Can you solve the same? Here is the puzzle: Five less than six times the largest of three consecutive positive integers is equal to the square of the smaller number minus twice the middle one. Find all the three integers. Input your answer in ascending order of the three numbers.",

"John can paint his house in 10 days. After working for 3 days, he hires a helper and the two of them complete the task in next 5 days. How long will it take the helper to complete the task alone?",


"40 litre solution of Sulphuric acid has 18 litres of Sulphuric acid. How many litres of water will be available in a 4% Sulphuric acid solution, assuming that, the 4% sulphuric acid solution also contains 18 litres of Sulphuric acid?",

"A plane needs to be divided into 121 distinct regions. To draw a line, it costs $101. If Tom is a miser and also someone with a good logical mind, how much money in $ would he have spent to achieve the target?",

"If a man walks to work and rides back home, it takes him an hour and a half. When he rides both ways, it takes 30 minutes. How long would it take him to make the round trip by walking? (Answer in minutes)",

"* Samuel, the bot, is standing in position A(1,1) of a 8 X 6 rectangular grid . He is allowed to move either right or down. He travels through the edges of the grids. He is not allowed to move up or left. By how many possible ways, he can reach B(8,6) from A?
 <br>
 <img src='http://localhost/ros/assets/images/fourth.png'/>
",
	


"The beginning of baseball season, you make a bet with a friend. For every game, the Mudville Nine plays, you pay him 5$ when they lose, while he pays you 7$ when they win. Mudville Nine played 156 games in the season. When the game is over, you find that, you came out exactly even. How many games did the Mudville Nine win?",

"Find the next two numbers in the series:<br>

4, 6, 12, 18, 30, __ , __<br>

(Type the answer without spaces. Eg. If 12 and 13 are the two numbers, format is 1213)",

"* There was a place called  “Land of mystery”, which had special creatures called “Togepi”. Each pair of togepi needs two months initially for growth and after two months, they produce one pair of togepi in the every successor month. Assuming that there was one pair of togepi at the first month (i.e. by the end of third month, this pair would have produced one new pair and it would be one month large), find the number of togepi in the Land of Mystery by the end of one and a half years.",

"Decode the following message:<br>

takouynh

(answer in lowercase. No space allowed)"


					);

		$p     = $rr1->points;
		$answered     = $rr1->answered;//total no of questions answered.
		$totalquestions=count($ques);
		
		$t=time();
		$rs = $this->db->query("select st_time from start_cerebra");
        $rem=0;
        if ($rs->num_rows() == 1) {
            $rrs     = $rs->row();
            $st_time = $rrs->st_time;
            $rem=$t-human_to_unix($st_time);
?>
<script type="text/javascript">
			var phptimestamp = "<? echo human_to_unix($st_time)+5400;?>";			
			 
		</script>
<?
            //$diff    = $t - $st_time;
            //$rem     = ($diff + 109899) - $t;
			$flag=1;
		}
		
	if($rem<=0){
			$msg="<h2>Please wait till 20:00 IST !!</h2></div>";
						$flag=0;
		}
		
		if($flag==1){
			if($rem>=5400)
			{
				$msg="<h2>Cerebra main contest ended !! </h2></div>";
				$flag=0;
			}
		}
		

				
					

		//	$time_dif=$t-human_to_unix($st_time);				
			
			$totalques=count($ques);
			$code='<font color="#800080"></h2><div class="col-md-9">';
			
			
			if($totalquestions==$answered)
			{
				$code.="<h2>You have completed!!</h2>";
				$code.="</div>";
			}
			else if($flag==0){
				$code.=$msg;
			}
			
			else{
					$code.='<div id="fixed-div">
<div class="row"><h3><div id="countdown"></div></h3>
<h3 align="left"><div style="display:inline;">Points : &nbsp' . $p . '</div></h3></div></div>
    <script>
    // set the date were counting down to

var target_date =new Date(phptimestamp*1000);
 
// variables for time units
var days, hours, minutes, seconds;
 
// get tag element
 
// update the tag with id "countdown" every 1 second
setInterval(function () {
 
    // find the amount of "seconds" between now and target
    var current_date = new Date().getTime();
    var seconds_left = (target_date - current_date) / 1000;
 
    // do some time calculations
    
    seconds_left = seconds_left % 86400;
     
    hours = parseInt(seconds_left / 3600);
    seconds_left = seconds_left % 3600;
     
    minutes = parseInt(seconds_left / 60);
    seconds = parseInt(seconds_left % 60);
     if(minutes<=0)
 { 
if(seconds<=0) { location.reload(true); 
     document.getElementById("countdown").innerHTML="Time is Up !!" ; }
else document.getElementById("countdown").innerHTML="Time is  Running Up !! "+ hours + "h: "+ minutes + "m: " + seconds + "s";
}
    // format countdown string + set tag value
if(seconds>=0 && minutes>0)
    document.getElementById("countdown").innerHTML = hours + "h: "+ minutes + "m: " + seconds + "s";  
 
}, 1000);
    </script><div id="mascot" class="col-md-4 col-md-offset-8 "></div></h3> 
			';
					for ($u = 1; $u <$totalques; $u++) {

				if (!$qa[$u]) {
				$code .= '<br>
				<b>Question ' . $u . '</b>
				<div class="span6"><b>Attempts : </b>&nbsp;
				<div style="display:inline;">' . $qw[$u] . '</div></div>
			<form name="unanswered' .$u. '" method="post" action="http:/localhost/cerebra/submit">
			<input type="hidden" name="level" value="' .$u. '"/>
			<br>' . $ques[$u] . '<br>
			<br>
			<input type="text" class="form-control input-lg" name="answer" id="t' . $u . '" placeholder="Your Answer Here!!" tab-index="'.$u.'"/>
			<br><button type="submit" class="btn btn-primary btn-lg" id="but'.$u.'" style="float:right;"  >Submit</button>
			</form>';
								} 

			else {
						$code .= '<br><div clas="span4" ><div class="well alert-success round">
									<b>Question ' . $u . '</b>
									<div class="span4"><b>Attempts : </b>&nbsp;
									<div id=athena_attempts_t' . $u . ' style="display:inline;">' . $qw[$u] . '</div></div>
									<div class="span4"><div id=qc' . $u . ' style="display:inline;">
									<strong>Answered Correctly!</strong></div><div id=qs' . $u . '></div></div></div></div>';
								}
					}
					
					
			}
			return $code;
	
	

}

public function getanswer($level,$answer,$kid)
{
	//return 10;
	$answer_arr=array("0",
"647","four","655656","1/8","7","26820","4652","117","58.32","2","1330","paulwalker","40","99","uncle","1","7","120000","337","5","123048169131","kurukshetra","15","10","49","24","35","31","5","480","91011","25","432","1515","150","792","65","4260","5168","thankyou"
	);
	 $t  = time();
        $rs = $this->db->query("select st_time from start_cerebra");
        if ($rs->num_rows() == 1) {
            $rrs     = $rs->row();
            $st_time = $rrs->st_time;
            $diff    = $t - human_to_unix($st_time);
            if ($diff > 5400)
                return ;
                }
		if(trim($answer)==null) return;
		
		else{
		
		$q1="select points,answered from cerebra_users where kid=?";
		$r1= $this->db->query($q1,$kid);
		$rr1   = $r1->row();
		$q2    = "select qid,attempt,flag from k13_cerebra where kid=?";
		$r2    = $this->db->query($q2,$kid);
		$rr2   = $r2->row();
		$qid=array(0);
		foreach($r2->result() as $row)
			$qid[]=$row->qid;
		
		$qa=array(0);
		$qw=array(0);
		//$qa    = $rr2->flag;
		//$qw    = $rr2->attempt;
		foreach($r2->result() as $row)
			{
				$qa[]=$row->flag;
				$qw[] = $row->attempt;
			}
		
		$p     = $rr1->points;
		$answered     = $rr1->answered;
			if(strcmp($answer,$answer_arr[$level])==0)
			{

				$p=$p+3;
				$answered=$answered+1;
				$qq = "update k13_cerebra set flag='1' where kid='$kid' and qid='$level'";
                $this->db->query($qq);
                $ar = "update cerebra_users set points='$p',answered='$answered' where kid='$kid'";
                $this->db->query($ar);

                 	$config['appId'] = FB_APPID;
                    $config['secret'] = FB_SECRET;
                    $config['cookie'] = true;
              
              $this->load->library('facebook-source/facebook',$config);
                   
                    $facebook = new Facebook(array(
                        'appId'  => FB_APPID,
                        'secret' => FB_SECRET,
                    ));
                     $user = $facebook->getUser();
                    if($user)
                      {
                      try {
                            $publishStream = $facebook->api("/$user/feed", 'post', array(
                              'message' => "Started playing Cerebra Set-4",
                              'link'    => 'http://kurukshetra.org.in/cerebra',
                              'picture' => 'http://mediahive.kurukshetra.org.in/2013/thumb/CER.jpg',
                              'name'    => 'Cerebra | Kurukshetra 2013',
                              'description'=> 'Cerebra is the Online Puzzle Challenge of Kurukshetra\'13 conducted for 90 minutes. Its open for both Students and Corporates. Get ready for the challenge!'
                              )
                   
                            );
                   //echo "asassa";
                          } catch (FacebookApiException $e) {
                            
                       }   
                    }
			}
			else
			{
				$attempt=$qw[$level];
				$attempt=$attempt+1;
				$p=$p-1;
				$qq = "update k13_cerebra set attempt='$attempt' where kid='$kid' and qid='$level'";
				$ar = "update cerebra_users set points='$p' where kid='$kid'";
				$this->db->query($qq);
				$this->db->query($ar);
			}
			
	}
}
}
