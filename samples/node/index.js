// Imports
const axios = require('axios')

// API key
const API_KEY = '<YOUR_API_KEY>' // (Get your API key here: https://app.rytr.me/account/api-access)

// API URL
const API_URL = 'https://api.rytr.me/v1'

// Step 1 - Identify language ID (use language list API endpoint)
// For example: English
const languageIdEnglish = '607adac76f8fe5000c1e636d'

// Step 2 - Identify tone ID (use tone list API endpoint)
// For example: Convincing
const toneIdConvincing = '60572a639bdd4272b8fe358b'

// Step 3 - Identify use case ID (use use-case list API endpoint)
// Magic command
const useCaseMagicCommandId = '60ed7113732a5b000cf99e8e'
// Job description
const useCaseJobDescriptionId = '60586b31cdebbb000c21058d'
// Blog section writing
const useCaseBlogSectionId = '60584cf2c2cdaa000c2a7954'

// get use-case detail
async function useCaseDetailById(useCaseId) {
  try {
    const { data } = await axios({
      method: 'get',
      url: `${API_URL}/use-cases/${useCaseId}`,
      headers: {
        Authentication: `Bearer ${API_KEY}`,
        'Content-Type': 'application/json',
      },
    })

    return data ? data.data : null
  } catch (error) {
    console.log(error)
  }

  return null
}

// ryte
async function ryte({ useCaseId, inputContexts }) {
  try {
    const { data } = await axios({
      method: 'post',
      url: `${API_URL}/ryte`,
      headers: {
        Authentication: `Bearer ${API_KEY}`,
        'Content-Type': 'application/json',
      },
      data: {
        languageId: languageIdEnglish,
        toneId: toneIdConvincing,
        useCaseId,
        inputContexts,
        variations: 1,
        userId: 'USER1',
        format: 'html',
      },
    })

    return data ? data.data : null
  } catch (error) {
    console.log(error)
  }

  return null
}

;(async () => {
  // Example 1
  console.log('Example 1 - Magic Command')
  const useCaseMagicCommand = await useCaseDetailById(useCaseMagicCommandId)

  if (useCaseMagicCommand) {
    let inputContexts = {
      [useCaseMagicCommand.contextInputs[0].keyLabel]:
        'Write an email for taking a sick leave',
    }

    let output = await ryte({
      useCaseId: useCaseMagicCommand._id,
      inputContexts,
    })

    console.log('Output:', output)
  }

  // Example 2
  console.log('Example 2 - Job description')
  const useCaseJobDescription = await useCaseDetailById(useCaseJobDescriptionId)

  if (useCaseJobDescription) {
    const inputContexts = {
      [useCaseJobDescription.contextInputs[0].keyLabel]: 'Product Manager',
    }

    const output = await ryte({
      useCaseId: useCaseJobDescription._id,
      inputContexts,
    })

    console.log('Output:', output)
  }

  // Example 3
  console.log('Example 3 - Blog section writing')
  const useCaseBlogSection = await useCaseDetailById(useCaseBlogSectionId)

  if (useCaseBlogSection) {
    const inputContexts = {
      [useCaseBlogSection.contextInputs[0].keyLabel]:
        'Role of AI Writers in the Future of Copywriting',
      [useCaseBlogSection.contextInputs[1].keyLabel]:
        'ai writer, blog generator, best writing software',
    }

    const output = await ryte({
      useCaseId: useCaseBlogSection._id,
      inputContexts,
    })

    console.log('Output:', output)
  }
})()
