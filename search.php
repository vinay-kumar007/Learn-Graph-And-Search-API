<?php


$today = strtotime("now") * 1000;//date value in milliseconds

$start_date = $today - (60 * 24 * 60 * 60 * 1000);//search last 60 days of data

$todays= $today/1000;

$existCounter = 0;
$doesNotExistCounter = 0;
require_once 'Requests-master/Requests-master/library/Requests.php';
Requests::register_autoloader();
$headers = array('Accept' => 'application/json');
$json='{
    "query": {
        "type": "all",
        "allQueries": [
            {
                "field": "body.publishDate.date",
                "from": '.($start_date).',
                "to": '.($today).',
                "includeFrom": true,
                "includeTo": false,
                "type": "range"
            },
			{
                "field": "metaData.url",
                "value": "http://vgd.no/sport/fotball-norsk/tema/1834127/tittel/kaaring-stadioner-i-norge/innlegg/45597508/#45591849",
                "type": "term"
            }
        ]
    },https://github.com/meltwater/Onlooker
    "viewRequests": {
		
        "expressive": {
			 
            "fields": [
				"attachments",
				
				"body.links",
				"body.byLine.text",
				"body.content.text",
				"body.contentTags",
				"body.ingress.text",
				"body.mentions",
				"body.publishDate.date",
				"body.title.text",
				
				"enrichments.categories",
				"enrichments.conceptsTop",
				"enrichments.keyPhrases",
				"enrichments.namedEntities",
				"enrichments.sentences",
				"enrichments.sentiment",
				"enrichments.charikarLSH",
				"enrichments.comscoreUniqueVisitors",
				"enrichments.languageCode",
				"enrichments.location.countryCode",
				"enrichments.location.voiv",
				"enrichments.sentiment.discrete",
				"enrichments.sentiment.numeric",
				"enrichments.socialScores.fb_likes",
				"enrichments.socialScores.ir_links",
				"enrichments.socialScores.ir_score",
				"enrichments.socialScores.klout",
				"enrichments.socialScores.tw_followers",
				"enrichments.socialScores.yt_views",
				
				"id",
				
				"metaData.applicationTags",
				"metaData.disambiguatedSourceId",
				"metaData.inReplyTo.url",
				"metaData.indexingTime",
				"metaData.mediaType",
				"metaData.provider.specifier",
				"metaData.provider.type",
				"metaData.source.allowPdf",
				"metaData.source.id",
				"metaData.source.informationType",
				"metaData.source.language",
				"metaData.source.location.countryCode",
				"metaData.source.location.voiv",
				"metaData.source.mediaType",
				"metaData.source.name",
				"metaData.source.pricing",
                "metaData.source.socialOriginType",
                "metaData.source.systemData.legacySupport.buzzId",
				"metaData.source.systemData.legacySupport.newsId",
				"metaData.source.url",
				"metaData.url",
				"metaData.userTags",
				"metaData.authors",
				
				"systemData.legacySupport.buzzId",
				"systemData.legacySupport.newsId",
				"systemData.policies.storage.private",
				"systemData.policies.storage.privateTo",
				"systemData.status"
				
		
            ],
            "type": "sortedResultList",
            "sortDirectives": [
                {
                    "script": "(10 + .enrichments.comscoreUniqueVisitors) * .enrichments.sentiment.numeric ",
                    "sortOrder": "DESC"
                }
            ]
        },
		"total": {
          "type": "count"
        }
    }
}
';
$fh_search_service = ("//meltwater search service API// ");
$result = Requests::post($fh_search_service, $headers ,$json);


$myText = serialize($result);;

try {
	$myfile = fopen("ho.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $myText);
	fclose($myfile);
}
catch(Exception $e) {
	printf("Met with an accident");
}

	$fname = fopen("ho.txt","r") or die("Unable to open file!");
	$content=fread($fname,filesize("ho.txt"));
	//echo $content;
	$del = strstr($content, 'Connection: close');
	$del1=str_replace("Connection: close", "",$del);
	$del2= strstr($del1,'";s:7:"headers";', true);
	$token = strtok($del2, ",");
	
	$fchange = fopen("ho.json","w") or die("Unable to open file!");
	fwrite($fchange, $del2);
	fclose($fchange);
	fclose($fname);
	$str = file_get_contents('ho.json');
	$json = json_decode($str, true);
	echo '<pre>' . print_r($json, true) . '</pre>';
	
	echo "metaData_quiddityType  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['_quiddityType'].'<br>';
	echo "metaData_Provider_QuiddityType  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['provider']['_quiddityType'].'<br>';
	echo "metaData_Provider_Type  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['provider']['type'].'<br>';
	echo "metaData_Provider_QuiddityVersion  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['provider']['_quiddityVersion'].'<br>';
	echo "metaData_IndexingTime  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['indexingTime'].'<br>';
	echo "metaData_MediaType  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['mediaType'].'<br>';
	echo "metaData_Source_quiddityType  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['_quiddityType'].'<br>';
	echo "metaData_Source_SocialOriginType  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['socialOriginType'].'<br>';
	echo "metaData_Source_Location_quiddityType  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['location']['_quiddityType'].'<br>';
	echo "metaData_Source_Location_countryCode  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['location']['countryCode'].'<br>';
	echo "metaData_Source_Location_quiddityVersion  :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['location']['_quiddityVersion'].'<br>';
	echo "metaData_Source_language :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['language'].'<br>';
	echo "metaData_Source_mediaType :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['mediaType'].'<br>';
	echo "metaData_Source_id :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['id'].'<br>';
	echo "metaData_Source_pricing :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['pricing'].'<br>';
	echo "metaData_Source_informationType :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['informationType'].'<br>';
	echo "metaData_Source_quiddityVersion :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['source']['_quiddityVersion'].'<br>';
	echo "metaData_url :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['url'].'<br>';
	echo "metaData_quiddityVersion :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['_quiddityVersion'].'<br>';
	echo "metaData_authors_quiddityType :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['_quiddityType'].'<br>';
	echo "metaData_authors_twitterInfo_quiddityType :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['_quiddityType'].'<br>';
	echo "metaData_authors_twitterInfo_followers :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['followers'].'<br>';
	echo "metaData_authors_twitterInfo_displayName :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['displayName'].'<br>';
	echo "metaData_authors_twitterInfo_following :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['following'].'<br>';
	echo "metaData_authors_twitterInfo_imageUrl :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['imageUrl'].'<br>';
	echo "metaData_authors_twitterInfo_bio :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['bio'].'<br>';
	echo "metaData_authors_twitterInfo_listedCount :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['listedCount'].'<br>';
	echo "metaData_authors_twitterInfo_quiddityVersion :".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['followers'].'<br>';
	echo "metaData_authors_twitterInfo_username:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['twitterInfo']['username'].'<br>';
	echo "metaData_authors_authorInfo_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['authorInfo']['_quiddityType'].'<br>';
	echo "metaData_authors_authorInfo_externalId:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['authorInfo']['externalId'].'<br>';
	echo "metaData_authors_authorInfo_handle:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['authorInfo']['handle'].'<br>';
	echo "metaData_authors_authorInfo_rawName:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['authorInfo']['rawName'].'<br>';
	echo "metaData_authors_authorInfo_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['authorInfo']['_quiddityVersion'].'<br>';
	echo "metaData_authors_link:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['link'].'<br>';
	echo "metaData_authors_languageCode:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['languageCode'].'<br>';
	echo "metaData_authors_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['metaData']['authors']['0']['_quiddityVersion'].'<br>';
	echo "quiddity_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['_quiddityType'].'<br>';
	echo "systemData_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['_quiddityType'].'<br>';
	echo "systemData_policies_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['policies']['_quiddityType'].'<br>';
	echo "systemData_policies_storage_private:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['policies']['storage']['private'].'<br>';
	echo "systemData_policies_storage_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['policies']['storage']['_quiddityType'].'<br>';
	echo "systemData_policies_storage_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['policies']['storage']['_quiddityVersion'].'<br>';
	echo "systemData_policies_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['policies']['_quiddityVersion'].'<br>';
	echo "systemData_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['_quiddityVersion'].'<br>';
	echo "systemData_status:".(string) $json['views']['expressive']['results']['0']['quiddity']['systemData']['status'].'<br>';
	echo "id:".(string) $json['views']['expressive']['results']['0']['quiddity']['id'].'<br>';
	echo "body_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['_quiddityType'].'<br>';
	echo "body_publishDate_date:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['publishDate']['date'].'<br>';
	echo "body_publishDate_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['publishDate']['_quiddityType'].'<br>';
	echo "body_publishDate_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['publishDate']['_quiddityVersion'].'<br>';
	echo "body_links_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['links']['0']['_quiddityType'].'<br>';
	echo "body_links_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['links']['0']['_quiddityVersion'].'<br>';
	echo "body_links_url:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['links']['0']['url']['0'].'<br>';
	echo "body_content_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['content']['_quiddityType'].'<br>';
	echo "body_content_text:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['content']['text'].'<br>';
	echo "body_content_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['content']['_quiddityVersion'].'<br>';
	echo "body_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['body']['_quiddityVersion'].'<br>';
	echo "_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['_quiddityVersion'].'<br>';
	echo "enrichments_sentiment_discrete:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['sentiment']['discrete'].'<br>';
	echo "enrichments_sentiment_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['sentiment']['_quiddityType'].'<br>';
	echo "enrichments_sentiment_numeric:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['sentiment']['numeric'].'<br>';
	echo "enrichments_sentiment_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['sentiment']['_quiddityVersion'].'<br>';
	echo "enrichments_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['_quiddityType'].'<br>';
	echo "enrichments_keyPhrases_Array0_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['0']['_quiddityType'].'<br>';
	echo "enrichments_keyPhrases_Array0_phrase:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['0']['phrase'].'<br>';
	echo "enrichments_keyPhrases_Array0_relevance:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['0']['relevance'].'<br>';
	echo "enrichments_keyPhrases_Array0_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['0']['_quiddityVersion'].'<br>';
	echo "enrichments_keyPhrases_Array1_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['1']['_quiddityType'].'<br>';
	echo "enrichments_keyPhrases_Array1_phrase:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['1']['phrase'].'<br>';
	echo "enrichments_keyPhrases_Array1_relevance:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['1']['relevance'].'<br>';
	echo "enrichments_keyPhrases_Array1_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['1']['_quiddityVersion'].'<br>';
	echo "enrichments_keyPhrases_Array2_quiddityType:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['2']['_quiddityType'].'<br>';
	echo "enrichments_keyPhrases_Array2_phrase:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['2']['phrase'].'<br>';
	echo "enrichments_keyPhrases_Array2_relevance:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['2']['relevance'].'<br>';
	echo "enrichments_keyPhrases_Array2_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['keyPhrases']['2']['_quiddityVersion'].'<br>';
	echo "enrichments_languageCode:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['languageCode'].'<br>';
	echo "enrichments_quiddityVersion:".(string) $json['views']['expressive']['results']['0']['quiddity']['enrichments']['_quiddityVersion'].'<br>';

	
	
?>	
