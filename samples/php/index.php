<?php

// API key
define('API_KEY', '<YOUR_API_KEY>'); // (Get your API key here: https://app.rytr.me/account/api-access)

// API endpoint
define('API_URL', 'https://api.rytr.me/v1');

// Step 1 - Identify language ID (use language list API endpoint)
// For example: English
$languageIdEnglish = '607adac76f8fe5000c1e636d';

// Step 2 - Identify tone ID (use tone list API endpoint)
// For example: Convincing
$toneIdConvincing = '60572a639bdd4272b8fe358b';

// Step 3 - Identify use case ID (use use-case list API endpoint)
// Magic command
$useCaseMagicCommandId = '60ed7113732a5b000cf99e8e';
// Job description
$useCaseJobDescriptionId = '60586b31cdebbb000c21058d';
// Blog section writing
$useCaseBlogSectionId = '60584cf2c2cdaa000c2a7954';

// curl utility function
function curl($endpoint, $method, $data = array()) {
  $c = curl_init(API_URL . '/' . $endpoint);

  $dataString = json_encode($data);

  $headers = array('Authentication:'. 'Bearer ' . API_KEY);

  if($method === 'post') {
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, $dataString);

    array_push(
      $headers,
      'Content-Type: application/json',
      'Content-Length: ' . strlen($dataString)
    );
  }
  curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

  $data = curl_exec($c);

  curl_close($c);

  return $data;
}

// get use-case detail
function useCaseDetailById($useCaseId) {
  try {
    $endpoint = 'use-cases/' . $useCaseId;

    $response = curl($endpoint, 'get');

    $useCase = json_decode($response);

    if($useCase && isset($useCase->data)) {
      return $useCase->data;
    }
  } catch (Exception $error) {
    echo $error;
  }

  return null;
}

// ryte
function ryte($languageId, $toneId, $useCaseId, $inputContexts) {
  try {
    $endpoint = 'ryte';

    $data = array(
      'languageId' => $languageId,
      'toneId' => $toneId,
      'useCaseId' => $useCaseId,
      'inputContexts' => $inputContexts,
      'variations' => 1,
      'userId' => 'USER1',
      'format' => 'html',
    );

    $response = curl($endpoint, 'post', $data);

    if($response) {
      $useCase = json_decode($response);

      return $useCase->data;
    }
  } catch (Exception $error) {
    echo $error;
  }

  return null;
}

// Example 1
echo "Example 1 - Magic Command\n";
$useCaseMagicCommand = useCaseDetailById($useCaseMagicCommandId);
if($useCaseMagicCommand) {
  $key = $useCaseMagicCommand->contextInputs[0]->keyLabel;

  $inputContextsString = '{"'.$key.'":'. '"Write an email for taking a sick leave"'.'}';
  $inputContexts = json_decode($inputContextsString);

  $output = ryte(
    $languageIdEnglish,
    $toneIdConvincing,
    $useCaseMagicCommand->_id,
    $inputContexts
  );

  print_r($output);
}

// Example 2
echo "Example 2 - Job description\n";
$useCaseJobDescription = useCaseDetailById($useCaseJobDescriptionId);
if($useCaseJobDescription) {
  $keyRole = $useCaseJobDescription->contextInputs[0]->keyLabel;

  $inputContextsString = '{"'.$keyRole.'":'. '"Product Manager"'.'}';
  $inputContexts = json_decode($inputContextsString);

  $output = ryte(
    $languageIdEnglish,
    $toneIdConvincing,
    $useCaseJobDescription->_id,
    $inputContexts
  );

  print_r($output);
}

// Example 3
echo "Example 3 - Blog section writing\n";
$useCaseBlogSection = useCaseDetailById($useCaseBlogSectionId);
if($useCaseBlogSection) {
  $keyTopic = $useCaseBlogSection->contextInputs[0]->keyLabel;
  $keyKeywords = $useCaseBlogSection->contextInputs[0]->keyLabel;

  $inputContextsString = '{"'.$keyTopic.'":"Role of AI Writers in the Future of Copywriting", "'.$keyKeywords.'":"Role of AI Writers in the Future of Copywriting"}';
  $inputContexts = json_decode($inputContextsString);

  $output = ryte(
    $languageIdEnglish,
    $toneIdConvincing,
    $useCaseBlogSection->_id,
    $inputContexts
  );

  print_r($output);
}