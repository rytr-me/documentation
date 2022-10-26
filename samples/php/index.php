<?php

require 'util.php';

// API key
define('API_KEY', '<YOUR_API_KEY>'); // Get your API key here: https://app.rytr.me/account/api-access

// API endpoint
define('API_URL', 'https://api.rytr.me/v1');

// Language list
function languageList() {
  try {
    $endpoint = 'languages';

    $response = curl($endpoint, 'get');

    if($response) {
      $languages = json_decode($response);

      return $languages->data;
    }
  } catch (Exception $error) {
    echo $error;
  }

  return null;
}

// Tone list
function toneList() {
  try {
    $endpoint = 'tones';

    $response = curl($endpoint, 'get');

    if($response) {
      $tones = json_decode($response);

      return $tones->data;
    }
  } catch (Exception $error) {
    echo $error;
  }

  return null;
}

// Use case list
function useCaseList() {
  try {
    $endpoint = 'use-cases';

    $response = curl($endpoint, 'get');

    if($response) {
      $useCases = json_decode($response);

      return $useCases->data;
    }
  } catch (Exception $error) {
    echo $error;
  }

  return null;
}

// Use case detail
function useCaseDetail($useCaseId) {
  try {
    $endpoint = 'use-cases/' . $useCaseId;

    $response = curl($endpoint, 'get');

    if($response) {
      $useCase = json_decode($response);

      return $useCase->data;
    }
  } catch (Exception $error) {
    echo $error;
  }

  return null;
}

// Generate content
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
      $result = json_decode($response);

      return $result->data;
    }
  } catch (Exception $error) {
    echo $error;
  }

  return null;
}

(function() {
  // Get languages
  if(true) {
    $languages = languageList();
    print_r($languages);
  }

  // Get tones
  if(false) {
    $tones = toneList();
    print_r($tones);
  }

  // Get use-cases
  if(false) {
    $useCases = useCaseList();
    print_r($useCases);
  }

  // Get use-case detail
  if(false) {
    // Example use case: Magic command
    $useCaseIdMagicCommand = '60ed7113732a5b000cf99e8e';

    $useCase = useCaseDetail($useCaseIdMagicCommand);
    print_r($useCase);
  }

  // Generate content
  if(true) {
    // Step 1 - Identify language ID (use language list API endpoint)
    $languageIdEnglish = '607adac76f8fe5000c1e636d'; // English

    // Step 2 - Identify tone ID (use tone list API endpoint)
    $toneIdConvincing = '60572a639bdd4272b8fe358b'; // Convincing

    if (false) {
      // Step 3 - Identify use case ID (use use-case list API endpoint)
      $useCaseIdMagicCommand = '60ed7113732a5b000cf99e8e'; // Magic command

      // Step 4 - Identify use case details (use use-case detail API endpoint)
      $useCaseMagicCommand = useCaseDetail($useCaseIdMagicCommand);

      $key = $useCaseMagicCommand->contextInputs[0]->keyLabel;
      $inputContextsString = '{"'.$key.'":'. '"Write an email for taking a sick leave"'.'}';
      $inputContexts = json_decode($inputContextsString);

      // Step 5 - Generate content (use ryte API endpoint)
      $outputs = ryte(
        $languageIdEnglish,
        $toneIdConvincing,
        $useCaseIdMagicCommand,
        $inputContexts
      );

      print_r($outputs);
    }

    if (false) {
      // Step 3 - Identify use case ID (use use-case list API endpoint)
      $useCaseIdJobDescription = '60586b31cdebbb000c21058d'; // Job description

      // Step 4 - Identify use case details (use use-case detail API endpoint)
      $useCaseJobDescription = useCaseDetail($useCaseIdJobDescription);

      $key = $useCaseJobDescription->contextInputs[0]->keyLabel;
      $inputContextsString = '{"'.$key.'":'. '"Product Manager"'.'}';
      $inputContexts = json_decode($inputContextsString);

      // Step 5 - Generate content (use ryte API endpoint)
      $outputs = ryte(
        $languageIdEnglish,
        $toneIdConvincing,
        $useCaseIdJobDescription,
        $inputContexts
      );

      print_r($outputs);
    }

    if (true) {
      // Step 3 - Identify use case ID (use use-case list API endpoint)
      $useCaseIdBlogSection = '60584cf2c2cdaa000c2a7954'; // Blog section writing

      // Step 4 - Identify use case details (use use-case detail API endpoint)
      $useCaseBlogSection = useCaseDetail($useCaseIdBlogSection);

      $keyTopic = $useCaseBlogSection->contextInputs[0]->keyLabel;
      $keyKeywords = $useCaseBlogSection->contextInputs[1]->keyLabel;
      $inputContextsString = '{"'.$keyTopic.'":"Role of AI Writers in the Future of Copywriting", "'.$keyKeywords.'":"ai writer, blog generator, best writing software"}';
      $inputContexts = json_decode($inputContextsString);

      // Step 5 - Generate content (use ryte API endpoint)
      $outputs = ryte(
        $languageIdEnglish,
        $toneIdConvincing,
        $useCaseIdBlogSection,
        $inputContexts
      );

      print_r($outputs);
    }
  }
})();
