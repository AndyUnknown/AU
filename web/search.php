<?php 
	require 'vendor/autoload.php';
	use Elasticsearch\ClientBuilder;

	$data = $_POST;
	$client = ClientBuilder::create()->setHosts(['localhost:9200'])->build();

	if (array_key_exists("tags",$data)){
        
		$data=$data["tags"];
		$params = [
			'index' => 'test0',
			'body' => [
				'query' => [
					'function_score' =>[
						'query' => [
							'match' => [
								'biaoqian' => $data
							]
						],
						"functions"=>[
							[
							'field_value_factor' =>[
								'field' => 'xiai',
								'modifier'=>'none',
								'factor'=> 0.1
							]
							],
							[
						'field_value_factor'=>[
							'field'=> 'total_of_tpr',
							'modifier'=> 'log1p',
							'factor'=> 1
						]
						]
						],
						'score_mode'=> 'sum',
						'boost_mode'=>'sum'
					]
				]
			]
		];
		
		$response = $client->search($params);
		echo(json_encode($response));
	} 
	

	elseif(array_key_exists("name",$data)){
		$data=$data["name"];
		$params = [
			'index' => 'test0',
			'body' => [
				'query' => [
					'function_score' =>[
						'query' => [
							'match' => [
								'ch_name' => $data
							]
						],
						"functions"=>[
							[
							'field_value_factor' =>[
								'field' => 'xiai',
								'modifier'=>'none',
								'factor'=> 0.1
							]
							],
							[
						'field_value_factor'=>[
							'field'=> 'total_of_tpr',
							'modifier'=> 'log1p',
							'factor'=> 1
						]
						]
						],
						'score_mode'=> 'sum',
						'boost_mode'=>'sum'
					]
				]
			]
		];
		$response = $client->search($params);
		echo(json_encode($response));
	}
    else {
		echo "tag not specified";
	}

	
	
?>


