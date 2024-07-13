const express = require('express');
const { google } = require('googleapis');

const app = express();
const port = 3000;

const CLIENT_ID = 'your-client-id';
const CLIENT_SECRET = 'your-client-secret';
const REDIRECT_URI = 'http://localhost:3000/auth/google/callback'; // Update with your redirect URI

const oauth2Client = new google.auth.OAuth2(
  CLIENT_ID,
  CLIENT_SECRET,
  REDIRECT_URI
);

// Redirect to Google's OAuth consent screen
app.get('/auth/google', (req, res) => {
  const url = oauth2Client.generateAuthUrl({
    access_type: 'offline',
    scope: ['email', 'profile'] // Define required scopes here
  });
  res.redirect(url);
});

// Handle Google OAuth callback
app.get('/auth/google/callback', async (req, res) => {
  const { code } = req.query;
  try {
    const { tokens } = await oauth2Client.getToken(code);
    oauth2Client.setCredentials(tokens);
    // Use tokens.access_token to fetch user info or perform actions
    res.send('Google Sign-In successful!');
  } catch (error) {
    console.error('Error fetching access token', error);
    res.status(500).send('Error fetching access token');
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
