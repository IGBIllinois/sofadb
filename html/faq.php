<?php


  if(isset($_SESSION['loggedin']))
  {
     require_once("include/session.inc.php"); 
  } else {
       session_start();
  }
    require_once("../conf/settings.inc.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>FAQ</title>
<!-- CSS -->
 <link href="css/style.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="/css/jquery.multiselect.css" />

<script type="text/javascript" src="vendor/components/jquery/jquery.js"></script>
<script type="text/javascript" src="vendor/components/jquery-ui/ui/minified/jquery-ui.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- // Load Javascipt -->
</head>

<body>
<div id="top" class='new_header'>

    <div class='header_logo'>
            <img class='align_left' src="images/header.png">
    </div>
            <table style='float:right'><tr><td class='align_center' >
              <a href="http://www.sofainc.org" target="_blank"><img  src="images/sofaLogo.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://illinois.edu" target="_blank"><img src="images/illinois.png"></a>
            </td></tr><tr><td class='align_center' >
              <a href="https://www.csufresno.edu" target="_blank"><img src="images/fresnostate.png"></a>
            </td></tr></table>


</div>

<div id="hline">
<hr size="3" />
</div>

<div id="navbar">
  <ul>
    
<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1) {
?>
    <li><a href="index.php">My Cases</a></li>
    <li><a href="user/searchdb/?search=1">Search</a></li>
    <li><a href="faq.php">FAQ</a></li>
    <li><a href="contact/">Contact Us</a></li>
<?php

    } else {
?>
    <li><a href="index.php">Home</a></li>
<?php 
    }
?>
  </ul>
</div>

<div id="hline">
<hr size="3" />
</div>

<?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==1) {
?>
    
<div id="navigation"></div>
<?php

    }
?>
<div id="templatecontainer">
<div id="caseregion" style='margin-left:200px;'>

    
    
    
<?php
?>


    <h1 class='cntr'>Forensic Anthropology Database for Assessing Methods Accuracy (FADAMA)</h1>
<BR>
    <ul class='ul-left' style='padding:revert'>
        <li><a href="#scope"><B>Goals, Scope and Impact</B></a></li>
        <li><a href="#tutorials"><B>Tutorials</B></a></li>
        <li><a href="#faq"><B>FAQ</B></a></li>
        <li><a href="#general"><B>General</B></a></li>
        <ul style='padding:revert'>
            <li><a href="#FADAMAdev">How was FADAMA developed?</a></li>
            <li><a href="#FADAMAmanage">Who manages FADAMA?</a></li>
            <li><a href="#FDB">How does FADAMA relate to Forensic Anthropology Data Bank (FDB)?</a></li>
        </ul>  
        <BR>
        <li><B><a href='#userresponsibility'>FADAMA User Information and Responsibility</a></B></li>
        <ul style='padding:revert'>
            <li><a href="#FADAMAusers">Who are the targeted users of FADAMA?</a></li>
            <li><a href="#FADAMAresponsibilities">What are the FADAMA user responsibilities?</a></li>
            <li><a href="#FADAMAuserprivacy">How does FADAMA ensure user privacy?</a></li>
            <li><a href="#application">I applied for FADAMA membership a while ago, but my membership application is still pending, am I being denied?</a></li>
            <li><a href="#citation">How do I cite FADAMA if I want to use the data from the database in my research?</a></li>
        </ul>
        <BR>

        <li><a href="#case_elig"><B>Case eligibility and privacy</B></a></li>
        <ul style='padding:revert'>
            <li><a href="#cases">What cases are eligible for entry into FADAMA?</a></li>
            <li><a href="#casePrivacy">How does FADAMA ensure case privacy?</a></li>
            <li><a href="#dbaccess">Who can access the Database?</a></li>
            <li><a href="#whatCases">How should I choose what cases to submit?</a></li>
        </ul>
        <BR>
        <li><a href="#case_management"><B>Case management</B></A></li>
        <ul style='padding:revert'>
            <li><a href="#caseInfo">What kinds of case information are submitted to the database?</a></li>
            <li><a href="#deleteCase">Can I delete a case from the user-accessible database?</a></li>
            <li><a href="#pictures">My case is very complicated and I want to use pictures or have details to explain my reasoning, is that allowed?</a></li>
            <li><a href="#office">My office has many practicing forensic anthropologists, do we each upload our own cases?</a></li>
            <li><a href="#intern">Can an intern or graduate student working with me upload my cases?</a></li>
            <li><a href="#howLong">How long does it take to submit a case?</a></li>
        </ul>
        <BR>
        <li><a href="#methods_in_fadama"><B>Methods in FADAMA</B><a></li>
        <ul style='padding:revert'>
            <li><a href="#methodChoice">How did you choose methods to be included in the database?</a></li>
            <li><a href="#child">Should I upload cases where the decedent is a child?</a></li>
            <li><a href="#unlistedMethod">What if the methods I use aren’t listed on FADAMA?</a></li>
            <li><a href="#list">Is there a list of the methods currently included in FADAMA for data entry?</a></li>

        </ul>
        
    </ul>
    
<BR>
    
    <center><h1 id=scope >Goals, Scope and Impact</h1></center>

The forensic anthropology database for assessing methods accuracy (FADAMA) is an online forensic case database for documenting forensic anthropology methods and case outcomes. It serves the broader forensic anthropology community of practitioners, researchers and students. The main purpose of this database is to create avenues for forensic anthropology methods development and improvement by providing detailed data on method use, method outcomes, and individual and cumulative method accuracy. To this end, FADAMA is a repository for forensic anthropologists with past and/or present positively identified cases. All data submitted by practitioners is then amalgamated into a single database, which can be easily searched and downloaded for research purposes by FADAMA users.
<BR>
With the participation of practitioners and the submission of the current and past cases, FADAMA is the first forensic anthropological community-wide collective resource and has the potential to improve and standardize forensic anthropology practices. Currently, there exists no formal, organized space for the forensic anthropology community to share our approaches to casework and casework outcomes. While informal peer interaction is ongoing and useful, a significant measure that is missing in order for our discipline to self-assess is data on our casework itself. Electronic access to all submitted and anonymized case data is available for download for all FADAMA users to make possible the widest use of the data for education and research.

<BR>
<BR>
    
    <center><h1 id=scope>Method Reference List</h1></center>
<a href='https://andicyim.github.io/FADAMA/Method_list/method-list' target='blank'>Click here</a> for a list of methods currently available in FADAMA. Please see individual method description for more details. This list will be updated as new methods are added to FADAMA. If you do not see the methods you use in casework listed, you are welcome to request method additions through the Contact Us page above.
<BR>
<BR>
<BR>    
    
    <center><h1 id="tutorials">Tutorials</hi></center>
    
<ul style='padding:revert'>
    <li>Wiki: <a href='https://github.com/andicyim/FADAMA/wiki/FADAMA-User-Tutorial'>https://github.com/andicyim/FADAMA/wiki/FADAMA-User-Tutorial</a></li>
    <li>Videos:<ol>
    <li><a href='https://drive.google.com/file/d/1xWtxPCBWRiJBPPtdgBphX-U0utIfbp9J/view?usp=sharing'> Video 1 (basic functionality)</a></il>
    <li><a href='https://drive.google.com/file/d/1PD5ZeS0T45cQbcrLVj2owuKDTuYev951/view?usp=sharing'> Video 2 (case search and data download)</a></il>
    <li><a href='https://drive.google.com/file/d/1q64ZEtBp7XWMz7iQhOGyLPGmLsd_yd7M/view?usp=sharing'> Video 3 (downloaded data sheet)</a></il>
    </ol>
	</li>
</ul>

    <BR><BR><BR>
    
    <center><h1 id="faq">FAQs</h1></center>

<BR>
    <h1 id="general"><U>General</U></h1>
<BR>
    
<h1 id="FADAMAdev">How was FADAMA developed?</h1>

    In 2013, the database was proposed to the Society of Forensic Anthropologists (SOFA), with the original goal of creating a forensic anthropological community-wide collective resource for case data in order to observe trends in biological profile estimations and method preferences. For the next four years, SOFA’s database committee was tasked with understanding the logistical and data needs of the database and began working with developers to create a beta version. After a successful test phase where nearly 200 cases were submitted, SOFA database committee members Cris Hughes (University of Illinois at Urbana-Champaign, UIUC) and Chelsey Juarez (California State University, Fresno) applied for and received a National Institute of Justice (NIJ) grant (2018-DU-BX-0213) for improving the database. These improvements included a change in the interface to allow specific method outcome entry, the incorporation of a large number of methods into the database, and user optimization and efficiency.

<h1 id="FADAMAmanage">Who manages FADAMA?</h1>
    <BR>
    Per the NIJ grant, SOFA will retain a database committee to oversee the upkeep and management of FADAMA. The committee has administrative privileges to the FADAMA website and database. The primary role of the committee is to review user membership requests and troubleshoot any issues. The database is hosted on the SOFA server and the UIUC Institute of Genome Biology (IGB)’s web-based public interface.

    <BR>
<h1 id="FDB">How does FADAMA relate to Forensic Anthropology Data Bank (FDB)?</h1>
	The Forensic Anthropology Data Bank (FDB) was developed by The University of Tennessee, Knoxville in 1986. The purpose of the FDB is to understand contemporary skeletal variation and to allow for development of pertinent identification criteria of contemporary skeletons. The FDB contains demographic information and skeletal information from many cases, including medical history, occupation, stature, weight, cranial and postcranial metrics, various aging criteria scores, and non-metric information.
	FADAMA provides the opportunity for users to share relevant case data with the FDB. However, in contrast to FADAMA's anonymity, FDB sharing requires identifiable information about the case, including the case number and case agency. This is because the FDB needs to know who is submitting cases and what the case numbers are so that there is no duplication of cases.
	The data FADAMA shared with FDB include: case year, case number, case agency, relevant craniometric data (such as the ones associated with FORDISC), and relevant postcranial metric data (such as the ones associated with various stature estimation methods).
        
        <BR><BR><BR>
                    
<h1 id='userresponsibility'><U>Users</U></h1>
    <BR>  
    <h1 id="FADAMAusers">Who are the targeted users of FADAMA?</h1>	
    <BR>
    FADAMA is designed as a database for the broader forensic community. Currently only individuals associated with a recognized national or international forensic governing body can request access to the database. An individual who wishes to access FADAMA must be a regular member or be sponsored by a regular member of a recognized forensic organization (e.g. graduate or undergraduate students). These organizations include, but are not limited to: American Academy of Forensic Sciences (AAFS), Lain American Association of Forensic Anthropology (ALAF), Forensic Anthropology Society of Europe (FASE), European Association of Forensic Sciences (EAFS) and International Association of Forensic Sciences (IAFS). FADAMA administrators reserve the right to remove membership to the database and the right to decline membership.

    <h1 id="FADAMAresponsibilities">What are the FADAMA user responsibilities?</h1>
    <BR>
        Prior to submitting a case and its data to the database, it is the responsibility of each user to ensure they obtain permission from the entity which owns the case. For example, if you’re a contract forensic anthropologist working for a government agency, you should obtain permission from that agency before submitting cases. It is at the discretion of the user how to obtain that permission, but a template permission form is provided <a target='blank' href='./docs/Agency Permissions for FADAMA Submissions.docx'>here</a> if needed.

    <h1 id="FADAMAuserprivacy">How does FADAMA ensure user privacy?</h1>
    <BR>
    FADAMA has set up a safeguard to anonymize user submissions to the database. Each user will have their own private user profile space in which they manage their cases. Some of the data in this profile space may include information necessary for the user to properly identify and manage their cases, such as case numbers or the office name associated with the case. However, when the user is ready to share case data with other FADAMA users, they can “submit” the case to the database. Once submitted, no information that could link the case to a particular practitioner or institution is transferred to the user-accessible database, and is only maintained in the back-end of the database for organization purposes. Therefore, submitted cases are viewed and/or accessed for research as anonymous submissions, while important traceable information remains private in the user’s profile space.
            When you apply for access to FADAMA, you will be asked to provide general demographic information (education, years of casework, geographic region of employment). When a user’s submitted cases are viewed/accessed for download as anonymous submissions to other users, it may include some de-identified demographic information.
            It is important to note that the database committee which manages the database does have administrative privileges for the entire database, but will only access user information at the request of said user (e.g. for troubleshooting purposes), or if circumstances require a case to be removed from the database and the user has not completed the removal themselves (see Case Privacy section for more details).

    <h1 id="application">I applied for FADAMA membership a while ago, but my membership application is still pending, am I being denied?</h1>
    <BR>
    It takes about a week for the database committee to review and verify the information you provided in order to determine whether your membership is granted, so please be patient. We are working to process membership application as soon as possible. Only individuals not associated with a recognized forensic organization will be denied membership. If you are a student member of these organization, we request that you ask someone with a regular membership to sponsor you in your FADAMA membership application (see New Member link).

    <BR><BR>
    <h1 id="citation">How do I cite FADAMA if I want to use the data from the database in my research?</h1>
    <BR>
            Pending.

    <BR><BR><BR>
        
<h1 id='case_elig'><U>Case Eligibility and Privacy</U></h1>

    <BR>  
    <h1 id="cases">What cases are eligible for entry into FADAMA?</h1>
    <BR>
    Cases eligible for entry into FADAMA are restricted to current and past, non-historic, forensic/medicolegal cases that involve:
    1.	A forensic anthropological analysis of the biological profile was performed and, 
    2.	A positive or presumptive identification is associated with the case
    Cases need not have a complete estimation of the biological profile in order to be submitted (e.g. stature was not estimated), however, more comprehensive cases should ideally be given submission priority.

    <BR><BR>

    <h1 id="casePrivacy">How does FADAMA ensure case privacy?</h1>
    <BR>
    Prior to submitting a case and its data to the database, it is the responsibility of each user to ensure that any identifiable information of the decedent not be submitted to the user-accessible database as part of information contained in the biological profile methods or outcomes. This protects the decedent’s privacy. If identifiable information is found in the user-accessible database, the database committee will request that this information be removed by the user in 24 hours. If the user does not remove the identifiable information within the allotted time, the database committee will remove that case from the user-accessible database (but not from the user’s own private profile space).

    <BR><BR>

    <h1 id="dbaccess">Who can access the Database?</h1>
    <BR>
    The database accepts user-submitted case data that fits the criteria for inclusion detailed above in case eligibility. Any case data submitted to the database is accessible to all FADAMA members as anonymous submissions

    <BR><BR>

    <h1 id="whatCases">How should I choose what cases to submit? </h1>
    <BR>
    Please prioritize cases with full biological profile. It is also encouraged that you do not cherry-pick your submitted cases (e.g. excluding cases where the estimated biological profile may not have matched the actual decedent’s biological profile). These kinds of discrepancies are important aspects to our field, and methods in general are not a reflection of the actual practitioners. In addition, each practitioners’ submitted cases are viewed/accessed for download as anonymous submissions to other practitioners interacting with FADAMA. 

    <BR><BR><BR>

    <h1 id='case_management'><U>Case Management</U></h1>
    <BR>
    <h1 id="caseInfo">What kinds of case information are submitted to the database?</h1>
    <BR>
    For each case submission, the following information is requested. Case with partial information are still suitable for submission.
    <ol style='padding:revert'>
    <li>Method used for estimating sex, age, ancestry and stature</li>
    <li>Outcome of each individual method.</li>
    <li>Final case report estimates of sex, age, ancestry and stature.</li>
    <li>Actual age, sex, stature and ancestry of individual (upon identification).</li>
    </ol>
    **Specific traceable decedent information is not allowed**

    <BR><BR>
        
    <h1 id="deleteCase">Can I delete a case from the user-accessible database?</h1>
    <BR>
    Yes, once a case is removed, it will not appear in any future download or backup. However, because the database is updated and backed up every 24 hours, any change you made will not immediately take effect. You should also note that we cannot remove cases from any data that was already downloaded by our users. This means that you will not be able to remove cases from any past download or any past backup.

    <BR><BR>

    <h1 id="pictures">My case is very complicated and I want to use pictures or have details to explain my reasoning, is that allowed?</h1>
    <BR>
The Case Notes section is the ideal place to include case notes. However, we ask that you limit this to information pertinent to the interpretation of the data you have entered, and ensure that the information you include does not provide specifics that could compromise the anonymity on the case. Currently, a photo upload option is not available.
    <BR><BR>

    <h1 id="office">My office has many practicing forensic anthropologists, do we each upload our own cases?</h1>
    <BR>
    Principal investigators that work in a single office can each have their own accounts to manage their cases. However, if the PIs manage other staff working on cases, we suggest that any case worked by these individuals submitted through their PIs’ accounts for tracking purposes. Ultimately, it is up to the office how they would like to track cases, with the key being that they are ensuring that duplicate cases are not being submitted under separate accounts.

    <BR><BR>

    <h1 id="intern">Can an intern or graduate student working with me upload my cases?</h1>
    <BR>
    Yes. However, because students and interns are not permanent employees, we suggest that the PIs allow them to submit the case information through the PIs’ accounts in order to ensure PIs’ access to the submitted data.

    <BR><BR>
            
    <h1 id="howLong">How long does it take to submit a case?</h1>
    <BR>
    The time commitment to submit a case varies depending on how many methods were applied to the case. However, in our beta testing, once a practitioner is familiar with the user-friendly interface the average time for submitting a case is approximately 10-25 minutes depending on case complexity. 

    <BR><BR><BR>
        
<h1 id='methods_in_fadama'><U>Methods in FADAMA</U></h1>  
<BR>
    <h1 id="methodChoice">How did you choose methods to be included in the database?</h1>
    <BR>
    In building this database, we consulted forensic anthropology laboratories that have high caseloads (for example, Harris Country Institute of Forensic Sciences, New York City Office of Chief Medical Examiners, University of Tennessee Forensic Anthropology Center, and Defense POW/MIA Accounting Agency) and conducted a thorough literature review of existing forensic anthropology methods. If your method does not fit with the available templates, please select the option to “request new method” and we will complete this in a timely manner. If your method does not fit with the available templates, please use the option to request a new method via the Contact Us page, and we will complete this in a timely manner.

    <BR><BR>
        
    <h1 id="child">Should I upload cases where the decedent is a child?</h1>
    <BR>
    Currently most methods included in the database are for adults, however, there are plans to include subadult methods in future iterations of the database.

    <BR><BR>        

    <h1 id="unlistedMethod">What if the methods I use aren’t listed on FADAMA?</h1>
    <BR>
     Go to the Contact Us page and follow the prompt. Once the information you input is verified and the method is formatted by FADAMA administrators, the method will be available for all FADAMA users.
     <BR>
    Because some method literature is a compilation of methods from other primary sources, we ask FADAMA users to kindly consider reporting method outcomes using primary sources instead. For example, use Ascadi and Nemeskeri (1970) instead of Bass (2005) and/or Buikstra and Ubelaker (1994) for sexing of the skull, or use Phenice (1969) instead of Buikstra and Ubelaker (1994) for sexing of the pelvis. Please check our method list for more details.

    <BR><BR>        

    <h1 id="list">Is there a list of the methods currently included in FADAMA for data entry?</h1>
    <BR>
    <a href='https://andicyim.github.io/FADAMA/Method_list/method-list' target='blank'>Click here</a> for a list of methods currently available in FADAMA. Please see individual method description for more details. This list will be updated as new methods are added to FADAMA. If you do not see the methods you use in casework listed, you are welcome to request method additions through the Contact Us page above.


    
<BR>
<BR>
     
</div></div>
      <?php
require_once("include/footer.php");
?>
