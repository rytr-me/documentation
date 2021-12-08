// Imports
const axios = require("axios");

// API key
const API_KEY = "<API KEY>";

// Step 1 - Identify language ID (use language list API endpoint)
const languageIdEnglish = "607adac76f8fe5000c1e636d";

// Step 2 - Identify tone ID (use tone list API endpoint)
const toneIdConvincing = "60572a639bdd4272b8fe358b";

// Step 3 - Identify use case ID (use use-case list API endpoint)
const useCaseMagicCommandId = "60ed7113732a5b000cf99e8e";
const useCaseJobDescriptionId = "60586b31cdebbb000c21058d";

// use-case detail
async function useCaseDetailById(useCaseId) {
  try {
    const { data } = await axios({
      method: "get",
      url: `https://api.rytr.me/v1/use-cases/${useCaseId}`,
      headers: {
        Authentication: `Bearer ${API_KEY}`,
        "Content-Type": "application/json",
      },
    });

    return data ? data.data : null;
  } catch (error) {
    console.log(error);
  }

  return null;
}

// ryte
async function ryte({ useCaseId, inputContexts }) {
  try {
    const { data } = await axios({
      method: "post",
      url: "https://api.rytr.me/v1/ryte",
      headers: {
        Authentication: `Bearer ${API_KEY}`,
        "Content-Type": "application/json",
      },
      data: {
        languageId: languageIdEnglish,
        toneId: toneIdConvincing,
        useCaseId,
        inputContexts,
        variations: 1,
        userId: "USER1",
        format: "html",
      },
    });

    return data ? data.data : null;
  } catch (error) {
    console.log(error);
  }

  return null;
}

(async () => {
  // Example 1
  // Use-case - Magic command
  const useCaseMagicCommand = await useCaseDetailById(useCaseMagicCommandId);

  let inputContexts = {
    [useCaseMagicCommand.contextInputs[0].keyLabel]:
      "Write an email for taking a sick leave",
  };

  let output = await ryte({
    useCaseId: useCaseMagicCommand._id,
    inputContexts,
  });

  console.log("Output Magic Command", output);

  // Example 2
  // Use-case - Job description
  const useCaseJobDescription = await useCaseDetailById(
    useCaseJobDescriptionId
  );

  inputContexts = {
    [useCaseJobDescription.contextInputs[0].keyLabel]: "Product Manager",
  };

  output = await ryte({
    useCaseId: useCaseJobDescription._id,
    inputContexts,
  });

  console.log("Output Job Description", output);
})();
