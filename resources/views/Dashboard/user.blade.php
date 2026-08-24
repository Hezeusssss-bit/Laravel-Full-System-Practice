<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes fadeOut {
    from {
      opacity: 1;
      transform: translateY(0);
    }
    to {
      opacity: 0;
      transform: translateY(-10px);
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
    --green: #34c759;
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
    flex-direction:column;
    min-height:100vh;
    opacity: 1;
  }

  .dashboard-container{
    display:flex;
    flex-direction:column;
    min-height:100vh;
    max-width:1400px;
    margin:0 auto;
    padding:32px;
    width:100%;
  }

  .header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:32px;
    padding-bottom:24px;
    border-bottom:1px solid var(--panel-border);
  }

  .header-left{
    display:flex;
    align-items:center;
    gap:16px;
  }

  .header-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:24px;
    font-weight:600;
    letter-spacing:-0.01em;
  }

  .header-right{
    display:flex;
    align-items:center;
    gap:12px;
  }

  .live-time{
    font-family:'Space Grotesk', sans-serif;
    font-size:14px;
    color:var(--text-mid);
    padding:8px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    animation:pulse 2s ease-in-out infinite;
  }

  @keyframes pulse{
    0%, 100%{ opacity:1; }
    50%{ opacity:0.7; }
  }

  .logout-btn{
    padding:8px 16px;
    background:var(--field);
    border:1px solid var(--field-border);
    color:var(--text-mid);
    text-decoration:none;
    font-size:13px;
    font-weight:500;
    border-radius:8px;
    transition:all 0.15s ease;
  }

  .logout-btn:hover{
    border-color:var(--red);
    color:var(--red);
  }

  .user-menu{
    display:flex;
    align-items:center;
    gap:10px;
    padding:8px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    font-size:13px;
    color:var(--text-mid);
  }

  .user-avatar{
    width:32px;
    height:32px;
    border-radius:6px;
    background:linear-gradient(135deg, var(--green), var(--orange));
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:600;
    font-size:12px;
    color:var(--text-hi);
  }

  .stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));
    gap:16px;
    margin-bottom:32px;
  }

  .stat-card{
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:12px;
    padding:24px;
    transition:border-color .15s ease, transform .15s ease, box-shadow .15s ease;
    position:relative;
    overflow:hidden;
  }

  .stat-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:3px;
    background:linear-gradient(90deg, var(--green), var(--orange));
    opacity:0;
    transition:opacity .15s ease;
  }

  .stat-card:hover{
    border-color:var(--field-border);
    transform:translateY(-4px);
    box-shadow:0 8px 24px rgba(0,0,0,0.3);
  }

  .stat-card:hover::before{
    opacity:1;
  }

  .stat-label{
    font-size:12px;
    color:var(--text-low);
    letter-spacing:0.02em;
    text-transform:uppercase;
    margin-bottom:8px;
  }

  .stat-value{
    font-family:'Space Grotesk', sans-serif;
    font-size:32px;
    font-weight:600;
    color:var(--text-hi);
    margin-bottom:4px;
    transition:transform 0.3s ease;
  }

  .stat-value:hover{
    transform:scale(1.05);
  }

  .stat-change{
    font-size:13px;
    display:flex;
    align-items:center;
    gap:4px;
  }

  .stat-change.positive{
    color:var(--green);
  }

  .stat-change.negative{
    color:var(--text-mid);
  }

  .content-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
    margin-bottom:32px;
  }

  @media (max-width: 1024px){
    .content-grid{
      grid-template-columns:1fr;
    }
    
    .full-width{
      grid-column: auto;
    }
  }

  .card{
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:12px;
    overflow:hidden;
  }

  .card-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:20px 24px;
    border-bottom:1px solid var(--panel-border);
  }

  .card-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:16px;
    font-weight:600;
    color:var(--text-hi);
  }

  .card-content{
    padding:24px;
  }

  .welcome-section{
    background:linear-gradient(135deg, rgba(52,199,89,0.1), rgba(255,122,61,0.1));
    border:1px solid var(--panel-border);
    border-radius:12px;
    padding:32px;
    margin-bottom:32px;
  }

  .welcome-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:28px;
    font-weight:600;
    color:var(--text-hi);
    margin-bottom:8px;
  }

  .welcome-subtitle{
    font-size:14px;
    color:var(--text-mid);
    margin-bottom:24px;
  }

  .profile-info{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
    gap:16px;
  }

  .info-item{
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    padding:16px;
  }

  .info-label{
    font-size:12px;
    color:var(--text-low);
    text-transform:uppercase;
    letter-spacing:0.02em;
    margin-bottom:4px;
  }

  .info-value{
    font-size:14px;
    color:var(--text-hi);
    font-weight:500;
  }

  .quick-actions{
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:12px;
    padding:20px 24px;
  }

  .quick-action-card{
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    padding:16px;
    text-decoration:none;
    color:var(--text-mid);
    transition:all 0.15s ease;
    display:flex;
    flex-direction:column;
    gap:8px;
  }

  .quick-action-card:hover{
    border-color:var(--text-low);
    background:#232426;
    color:var(--text-hi);
    transform:translateY(-2px);
  }

  .quick-action-icon{
    font-size:20px;
  }

  .quick-action-title{
    font-size:13px;
    font-weight:500;
  }

  .quick-action-desc{
    font-size:11px;
    color:var(--text-low);
  }

  .activity-list{
    padding:0;
    list-style:none;
    max-height: 280px;
    overflow-y: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .activity-list::-webkit-scrollbar{
    display: none;
  }

  .activity-item{
    display:flex;
    gap:12px;
    padding:16px 24px;
    border-bottom:1px solid var(--panel-border);
  }

  .activity-item:last-child{
    border-bottom:none;
  }

  .activity-icon{
    width:36px;
    height:36px;
    border-radius:8px;
    background:var(--field);
    border:1px solid var(--field-border);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:14px;
    flex-shrink:0;
  }

  .activity-content{
    flex:1;
    min-width:0;
  }

  .activity-title{
    font-size:14px;
    color:var(--text-hi);
    margin-bottom:4px;
  }

  .activity-time{
    font-size:12px;
    color:var(--text-low);
  }

  .full-width{
    grid-column: 1 / -1;
  }

  @media (max-width: 768px){
    .dashboard-container{
      padding:20px;
    }
    
    .header{
      flex-direction:column;
      align-items:flex-start;
      gap:16px;
    }
    
    .stats-grid{
      grid-template-columns:1fr;
    }
  }

  :focus-visible{
    outline:2px solid var(--green);
    outline-offset:2px;
  }

  @media (prefers-reduced-motion: reduce){
    .page-transition-in, .page-transition-out{
      animation:none;
    }
  }
</style>
</head>
<body id="user-page">

  <div class="dashboard-container">
    <div class="header">
      <div class="header-left">
        <h1 class="header-title">User Dashboard</h1>
      </div>
      <div class="header-right">
        <div class="live-time" id="live-time">--:--:--</div>
        <div class="user-menu">
          <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
          <span>{{ auth()->user()->name }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      </div>
    </div>

    <div class="welcome-section">
      <h2 class="welcome-title">Welcome back, {{ auth()->user()->name }}!</h2>
      <p class="welcome-subtitle">Here's an overview of your account and recent activity.</p>
      
      <div class="profile-info">
        <div class="info-item">
          <div class="info-label">Name</div>
          <div class="info-value">{{ auth()->user()->name }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Email</div>
          <div class="info-value">{{ auth()->user()->email }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Account Type</div>
          <div class="info-value">User</div>
        </div>
        <div class="info-item">
          <div class="info-label">Member Since</div>
          <div class="info-value">{{ auth()->user()->created_at->format('M d, Y') }}</div>
        </div>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Account Status</div>
        <div class="stat-value">Active</div>
        <div class="stat-change positive">
          <span>●</span>
          <span style="color:var(--text-low)">Your account is in good standing</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Profile Completion</div>
        <div class="stat-value">100%</div>
        <div class="stat-change positive">
          <span>✓</span>
          <span style="color:var(--text-low)">Profile is complete</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Days Active</div>
        <div class="stat-value">{{ auth()->user()->created_at->diffInDays() }}</div>
        <div class="stat-change positive">
          <span>↑</span>
          <span style="color:var(--text-low)">Since registration</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">System Status</div>
        <div class="stat-value">Online</div>
        <div class="stat-change positive">
          <span>●</span>
          <span style="color:var(--text-low)">All systems operational</span>
        </div>
      </div>
    </div>

    <div class="content-grid">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Quick Actions</h2>
        </div>
        <div class="quick-actions">
          <a href="#" class="quick-action-card">
            <div class="quick-action-icon">👤</div>
            <div class="quick-action-title">Edit Profile</div>
            <div class="quick-action-desc">Update your personal information</div>
          </a>
          <a href="#" class="quick-action-card">
            <div class="quick-action-icon">🔒</div>
            <div class="quick-action-title">Change Password</div>
            <div class="quick-action-desc">Update your security settings</div>
          </a>
          <a href="#" class="quick-action-card">
            <div class="quick-action-icon">📧</div>
            <div class="quick-action-title">Email Settings</div>
            <div class="quick-action-desc">Manage email preferences</div>
          </a>
          <a href="#" class="quick-action-card">
            <div class="quick-action-icon">🔔</div>
            <div class="quick-action-title">Notifications</div>
            <div class="quick-action-desc">Configure notification settings</div>
          </a>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Recent Activity</h2>
        </div>
        <ul class="activity-list">
          <li class="activity-item">
            <div class="activity-icon">🔐</div>
            <div class="activity-content">
              <div class="activity-title">Logged in successfully</div>
              <div class="activity-time">Just now</div>
            </div>
          </li>
          <li class="activity-item">
            <div class="activity-icon">📅</div>
            <div class="activity-content">
              <div class="activity-title">Account created</div>
              <div class="activity-time">{{ auth()->user()->created_at->diffForHumans() }}</div>
            </div>
          </li>
          <li class="activity-item">
            <div class="activity-icon">✅</div>
            <div class="activity-content">
              <div class="activity-title">Profile completed</div>
              <div class="activity-time">{{ auth()->user()->created_at->diffForHumans() }}</div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    // Live time update
    function updateTime() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('en-US', { 
        hour12: false, 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit' 
      });
      document.getElementById('live-time').textContent = timeString;
    }
    
    updateTime();
    setInterval(updateTime, 1000);

    // Page transition on load
    document.body.classList.add('page-transition-in');
  </script>
</body>
</html>