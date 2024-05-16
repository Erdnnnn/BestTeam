const express = require('express');
const bodyParser = require('body-parser');
const { Sequelize, DataTypes } = require('sequelize');

const app = express();
const PORT = process.env.PORT || 3000;

// Connect to the database
const sequelize = new Sequelize('Task', 'root', '0406', {
  dialect: 'mysql',
  host: 'localhost',
  port: '1433'
});

// Define a User model
const User = sequelize.define('User', {
  username: {
    type: DataTypes.STRING,
    allowNull: false
  },
  email: {
    type: DataTypes.STRING,
    allowNull: false,
    unique: true
  },
  password: {
    type: DataTypes.STRING,
    allowNull: false
  }
});

// Synchronize the model with the database
sequelize.sync()
  .then(() => {
    console.log('Database synced');
  })
  .catch(err => {
    console.error('Error syncing database:', err);
  });

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// Serve static files
app.use(express.static('public'));

// Routes
app.get('/', (req, res) => {
    res.sendFile(__dirname + '/public/login.html');
});

app.get('/signup', (req, res) => {
    res.sendFile(__dirname + '/public/signup.html');
});

app.post('/signup', async (req, res) => {
    // Handle sign-up form submission
    const { username, email, password } = req.body;
    try {
        const user = await User.create({ username, email, password });
        console.log('User created:', user.toJSON());
        res.send('Sign up successful!');
    } catch (error) {
        console.error('Error creating user:', error);
        res.status(500).send('Error signing up');
    }
});

app.post('/login', async (req, res) => {
  // Handle login form submission
  const { username, password } = req.body;
  try {
      const user = await User.findOne({ where: { username } });
      if (user) {
          // User found, now check password
          if (user.password === password) {
              console.log('Login successful');
              res.send('Login successful!');
          } else {
              console.log('Incorrect password');
              res.status(401).send('Incorrect password');
          }
      } else {
          console.log('User not found');
          res.status(401).send('User not found');
      }
  } catch (error) {
      console.error('Error logging in:', error);
      res.status(500).send('Error logging in');
  }
});



// Start server
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
