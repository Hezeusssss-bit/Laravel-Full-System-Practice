<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Sign up</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: scale(0.95);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }
  
  @keyframes fadeOut {
    from {
      opacity: 1;
      transform: scale(1);
    }
    to {
      opacity: 0;
      transform: scale(0.95);
    }
  }
  
  .page-transition-in {
    animation: fadeIn 0.4s ease-in-out forwards;
  }
  
  .page-transition-out {
    animation: fadeOut 0.4s ease-in-out forwards;
  }
  
  :root{
    --black: #0a0a0a;
    --panel: #17181a;
    --panel-border: #262729;
    --field: #1f2022;
    --field-border: #313234;
    --text-hi: #f4f4f3;
    --text-mid: #a8a8a8;
    --text-low: #6f7072;
    --red: #ff3b30;
    --red-dim: #7a1d18;
    --orange: #ff7a3d;
  }

  *{box-sizing:border-box; margin:0; padding:0;}

  html,body{
    height:100%;
    background:var(--black);
    font-family:'Inter', sans-serif;
    color:var(--text-hi);
    -webkit-font-smoothing:antialiased;
  }

  body{
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
    padding:32px;
    opacity: 0;
  }

  .card{
    width:100%;
    max-width:920px;
    display:flex;
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:14px;
    overflow:hidden;
    box-shadow: 0 40px 80px -20px rgba(0,0,0,0.6);
  }

  /* ---------- LEFT: form ---------- */
  .left{
    flex:1 1 50%;
    padding:56px 48px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    min-width:0;
  }

  .eyebrow{
    font-size:13px;
    color:var(--text-low);
    letter-spacing:.02em;
    margin-bottom:8px;
  }

  h1{
    font-family:'Space Grotesk', sans-serif;
    font-size:28px;
    font-weight:600;
    letter-spacing:-0.01em;
    margin-bottom:10px;
  }

  .sub{
    font-size:14px;
    color:var(--text-mid);
    line-height:1.55;
    margin-bottom:34px;
  }

  form{
    display:flex;
    flex-direction:column;
    gap:18px;
  }

  .field{
    display:flex;
    flex-direction:column;
    gap:7px;
  }

  .field label{
    font-size:12.5px;
    font-weight:500;
    color:var(--text-mid);
  }

  .field input{
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    padding:11px 13px;
    font-size:14px;
    color:var(--text-hi);
    font-family:inherit;
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
  }

  .field input::placeholder{ color:var(--text-low); }

  .field input:focus{
    border-color:var(--red);
    box-shadow:0 0 0 3px rgba(255,59,48,0.15);
  }

  .field select{
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    padding:11px 13px;
    font-size:14px;
    color:var(--text-hi);
    font-family:inherit;
    outline:none;
    transition:border-color .15s ease, box-shadow .15s ease;
    cursor:pointer;
  }

  .field select:focus{
    border-color:var(--red);
    box-shadow:0 0 0 3px rgba(255,59,48,0.15);
  }

  .row-between{
    display:flex;
    align-items:center;
    justify-content:space-between;
    font-size:13px;
    margin-top:-2px;
  }

  .remember{
    display:flex;
    align-items:center;
    gap:8px;
    color:var(--text-mid);
  }

  .remember input{
    accent-color:var(--red);
    width:14px;
    height:14px;
  }

  .forgot{
    color:var(--red);
    text-decoration:none;
  }
  .forgot:hover{ text-decoration:underline; }

  .btn{
    background:var(--red);
    color:#fff;
    border:none;
    border-radius:8px;
    padding:12px 16px;
    font-size:14px;
    font-weight:600;
    font-family:inherit;
    cursor:pointer;
    transition:background .15s ease, transform .1s ease;
  }
  .btn:hover{ background:#fff; transform:translateY(-1px); }
  .btn:active{ transform:translateY(0); }

  .divider{
    display:flex;
    align-items:center;
    gap:12px;
    color:var(--text-low);
    font-size:12px;
    margin:22px 0 18px;
  }
  .divider::before, .divider::after{
    content:"";
    flex:1;
    height:1px;
    background:var(--panel-border);
  }

  .oauth{
    display:flex;
    gap:10px;
  }

  .oauth button{
    flex:1;
    background:var(--field);
    border:1px solid var(--field-border);
    color:var(--text-hi);
    font-family:inherit;
    font-size:13px;
    padding:10px;
    border-radius:8px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:border-color .15s ease, background .15s ease;
  }
  .oauth button:hover{ border-color:var(--text-low); background:#232426; }

  .footer-note{
    margin-top:26px;
    font-size:13px;
    color:var(--text-mid);
  }
  .footer-note a{
    color:var(--red);
    text-decoration:none;
    border-bottom:1px solid rgba(255,59,48,0.4);
  }
  .footer-note a:hover{ border-color:var(--red); }

  .back-button-container{
    position: absolute;
    top: 24px;
    left: 24px;
    z-index: 10;
  }

  .back-btn{
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: var(--field);
    border: 1px solid var(--field-border);
    color: var(--text-mid);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.15s ease;
  }

  .back-btn:hover{
    border-color: var(--text-low);
    background: #232426;
    color: var(--text-hi);
  }

  /* ---------- RIGHT: art panel ---------- */
  .right{
    flex:1 1 50%;
    position:relative;
    background:
      radial-gradient(120% 100% at 100% 0%, #3a0d0a 0%, #150403 45%, #0a0a0a 100%);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    min-height:520px;
  }

  .right::before{
    content:"";
    position:absolute;
    inset:0;
    background-image:
      linear-gradient(rgba(255,122,61,0.06) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,122,61,0.06) 1px, transparent 1px);
    background-size: 34px 34px;
    mask-image: radial-gradient(circle at 60% 45%, black 0%, transparent 70%);
  }

  .glyph{
    position:relative;
    width:78%;
    max-width:340px;
    animation: float 7s ease-in-out infinite;
  }

  @keyframes float{
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(1deg); }
  }

  .glyph svg{
    width:100%;
    height:auto;
    overflow:visible;
  }

  .glyph .fill-face{
    fill: rgba(255,59,48,0.08);
  }
  .glyph .fill-face-2{
    fill: rgba(255,122,61,0.05);
  }

  .glyph .edge{
    fill:none;
    stroke:var(--orange);
    stroke-width:1.1;
    opacity:0.85;
  }
  .glyph .edge-bright{
    fill:none;
    stroke:var(--red);
    stroke-width:1.3;
  }

  .tag{
    position:absolute;
    top:32px;
    left:32px;
    font-family:'Space Grotesk', sans-serif;
    font-size:15px;
    font-weight:600;
    letter-spacing:0.02em;
    color:var(--text-hi);
    opacity:0.9;
    z-index:2;
  }
  .tag span{ color:var(--red); }

  .caption{
    position:absolute;
    bottom:30px;
    left:32px;
    right:32px;
    z-index:2;
  }
  .caption .k{
    font-size:11px;
    letter-spacing:0.08em;
    text-transform:uppercase;
    color:var(--orange);
    margin-bottom:6px;
  }
  .caption .v{
    font-size:13px;
    color:var(--text-mid);
    line-height:1.5;
    max-width:320px;
  }

  @media (max-width: 760px){
    .card{ flex-direction:column; max-width:420px; }
    .right{ min-height:260px; order:-1; }
    .left{ padding:40px 30px; }
    .tag, .caption{ display:none; }
  }

  :focus-visible{
    outline:2px solid var(--red);
    outline-offset:2px;
  }

  @media (prefers-reduced-motion: reduce){
    .glyph{ animation:none; }
  }

  /* Modal Styles */
  .modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.8);
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:1000;
    opacity:0;
    visibility:hidden;
    transition:opacity 0.3s ease, visibility 0.3s ease;
  }

  .modal-overlay.active{
    opacity:1;
    visibility:visible;
  }

  .modal{
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:12px;
    padding:32px;
    max-width:400px;
    width:90%;
    text-align:center;
    transform:scale(0.9);
    transition:transform 0.3s ease;
  }

  .modal-overlay.active .modal{
    transform:scale(1);
  }

  .modal-icon{
    font-size:48px;
    margin-bottom:16px;
  }

  .modal-icon.success{
    color:#22c55e;
  }

  .modal-icon.error{
    color:var(--red);
  }

  .modal-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:20px;
    font-weight:600;
    color:var(--text-hi);
    margin-bottom:8px;
  }

  .modal-message{
    font-size:14px;
    color:var(--text-mid);
    line-height:1.5;
    margin-bottom:24px;
    white-space: pre-line;
  }

  .btn:disabled{
    opacity:0.6;
    cursor:not-allowed;
  }
</style>
</head>
<body id="signup-page">

  <div class="card">
    <div class="back-button-container">
      <a href="{{ route('login') }}" class="back-btn">← Back</a>
    </div>

    <div class="left">
      <div class="eyebrow">Create account</div>
      <h1>Sign up to get started</h1>

      <form method="POST" action="{{ route('signup.post') }}" autocomplete="off">
        @csrf
        <div class="field">
          <label for="name">Full name</label>
          <input id="name" name="name" type="text" placeholder="John Doe" required>
        </div>

        <div class="field">
          <label for="email">Email address</label>
          <input id="email" name="email" type="email" placeholder="you@company.com" required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" placeholder="••••••••" required>
        </div>

        <div class="field">
          <label for="confirm-password">Confirm password</label>
          <input id="confirm-password" name="password_confirmation" type="password" placeholder="••••••••" required>
        </div>

        <div class="field">
          <label for="position">Position</label>
          <select id="position" name="position" required>
            <option value="">Select your position</option>
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <button type="submit" class="btn" id="signup-btn">Create account</button>
      </form>

      <p class="footer-note">Already have an account? <a href="{{ route('login') }}" class="login-link">Sign in</a></p>
    </div>

    <div class="right">
      <div class="glyph">
        <svg viewBox="0 0 300 320" xmlns="http://www.w3.org/2000/svg">
          <!-- isometric stacked block cluster, original geometric composition -->

          <!-- back tall block -->
          <polygon class="fill-face" points="150,20 220,58 220,158 150,196 80,158 80,58"/>
          <polyline class="edge" points="150,20 220,58 220,158 150,196 80,158 80,58 150,20"/>
          <polyline class="edge" points="80,58 150,96 220,58"/>
          <polyline class="edge-bright" points="150,96 150,196"/>

          <!-- front-left block -->
          <polygon class="fill-face-2" points="60,150 130,188 130,268 60,306 -10,268 -10,188"/>
          <polyline class="edge" points="60,150 130,188 130,268 60,306 -10,268 -10,188 60,150"/>
          <polyline class="edge" points="-10,188 60,226 130,188"/>
          <polyline class="edge-bright" points="60,226 60,306"/>

          <!-- front-right block -->
          <polygon class="fill-face" points="230,150 300,188 300,268 230,306 160,268 160,188"/>
          <polyline class="edge" points="230,150 300,188 300,268 230,306 160,268 160,188 230,150"/>
          <polyline class="edge" points="160,188 230,226 300,188"/>
          <polyline class="edge-bright" points="230,226 230,306"/>

          <!-- connecting struts -->
          <line class="edge" x1="150" y1="196" x2="60" y2="150" opacity="0.5"/>
          <line class="edge" x1="150" y1="196" x2="230" y2="150" opacity="0.5"/>

          <!-- floating ring accent -->
          <ellipse class="edge-bright" cx="150" cy="120" rx="92" ry="34" opacity="0.5"/>
        </svg>
      </div>

      <div class="caption">
        <div class="k">Join the community</div>
        <div class="v">Create your account today and start building amazing things with our platform.</div>
      </div>
    </div>

  </div>

  <!-- Modal -->
  <div class="modal-overlay" id="modal-overlay">
    <div class="modal">
      <div class="modal-icon" id="modal-icon">✓</div>
      <h3 class="modal-title" id="modal-title">Success</h3>
      <p class="modal-message" id="modal-message">Account created successfully!</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const signupPage = document.getElementById('signup-page');
      const backBtn = document.querySelector('.back-btn');
      const loginLink = document.querySelector('.login-link');
      const signupForm = document.querySelector('form');
      const signupBtn = document.getElementById('signup-btn');
      const modalOverlay = document.getElementById('modal-overlay');
      const modalIcon = document.getElementById('modal-icon');
      const modalTitle = document.getElementById('modal-title');
      const modalMessage = document.getElementById('modal-message');
      
      if (signupPage) {
        // Trigger fade-in animation
        signupPage.classList.add('page-transition-in');
      }
      
      // Handle back button click
      if (backBtn && signupPage) {
        backBtn.addEventListener('click', function(e) {
          e.preventDefault();
          const targetUrl = this.getAttribute('href');
          
          // Add fade-out animation
          signupPage.classList.remove('page-transition-in');
          signupPage.classList.add('page-transition-out');
          
          // Navigate after animation completes
          setTimeout(function() {
            window.location.href = targetUrl;
          }, 400);
        });
      }
      
      // Handle login link click
      if (loginLink && signupPage) {
        loginLink.addEventListener('click', function(e) {
          e.preventDefault();
          const targetUrl = this.getAttribute('href');
          
          // Add fade-out animation
          signupPage.classList.remove('page-transition-in');
          signupPage.classList.add('page-transition-out');
          
          // Navigate after animation completes
          setTimeout(function() {
            window.location.href = targetUrl;
          }, 400);
        });
      }

      // Handle form submission with AJAX
      if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          // Disable button and show loading state
          signupBtn.disabled = true;
          signupBtn.textContent = 'Creating account...';
          
          const formData = new FormData(signupForm);
          
          fetch('{{ route('signup.post') }}', {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json',
            },
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            // Re-enable button
            signupBtn.disabled = false;
            signupBtn.textContent = 'Create account';
            
            if (data.success) {
              // Show success modal
              showModal('success', data.title || 'Success', data.message, data.redirect);
            } else {
              // Generate helpful suggestions based on errors
              let suggestions = [];
              if (data.errors) {
                if (data.errors.password) {
                  suggestions.push('💡 Password must be at least 8 characters long');
                }
                if (data.errors.email) {
                  suggestions.push('💡 Please enter a valid email address');
                }
                if (data.errors.name) {
                  suggestions.push('💡 Please enter your full name');
                }
                if (data.errors.password_confirmation) {
                  suggestions.push('💡 Make sure both passwords match');
                }
              }
              
              let errorMessage = data.message;
              if (suggestions.length > 0) {
                errorMessage += '\n\n' + suggestions.join('\n');
              }
              
              // Show error modal with suggestions
              showModal('error', data.title || 'Error', errorMessage, null);
              
              // Also show inline errors if available
              if (data.errors) {
                let errorHtml = '<div class="error-messages" style="background: rgba(255,59,48,0.1); border: 1px solid var(--red-dim); border-radius: 8px; padding: 12px; margin-bottom: 20px; font-size: 13px; color: var(--red);">';
                for (const field in data.errors) {
                  errorHtml += '<div>' + data.errors[field][0] + '</div>';
                }
                if (suggestions.length > 0) {
                  errorHtml += '<div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid rgba(255,59,48,0.2);">';
                  suggestions.forEach(suggestion => {
                    errorHtml += '<div style="margin-top: 4px;">' + suggestion + '</div>';
                  });
                  errorHtml += '</div>';
                }
                errorHtml += '</div>';
                
                // Remove existing error div if any
                const existingError = signupForm.querySelector('.error-messages');
                if (existingError) {
                  existingError.remove();
                }
                
                // Insert error messages
                signupForm.insertAdjacentHTML('afterbegin', errorHtml);
              }
            }
          })
          .catch(error => {
            // Re-enable button
            signupBtn.disabled = false;
            signupBtn.textContent = 'Create account';
            
            // Show error modal
            showModal('error', 'Error', 'An unexpected error occurred. Please try again.', null);
          });
        });
      }

      // Modal functions
      function showModal(type, title, message, redirectUrl) {
        modalIcon.textContent = type === 'success' ? '✓' : '✕';
        modalIcon.className = 'modal-icon ' + type;
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        
        modalOverlay.classList.add('active');
        
        if (type === 'success' && redirectUrl) {
          // Auto-redirect after 2 seconds on success
          setTimeout(function() {
            modalOverlay.classList.remove('active');
            
            // Add fade-out animation
            signupPage.classList.remove('page-transition-in');
            signupPage.classList.add('page-transition-out');
            
            // Navigate after animation completes
            setTimeout(function() {
              window.location.href = redirectUrl;
            }, 400);
          }, 2000);
        } else if (type === 'error') {
          // Auto-close error modal after 4 seconds
          setTimeout(function() {
            modalOverlay.classList.remove('active');
          }, 4000);
        }
      }
    });
  </script>

</body>
</html>