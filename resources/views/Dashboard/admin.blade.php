<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
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
    background:linear-gradient(135deg, var(--red), var(--orange));
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
    background:linear-gradient(90deg, var(--red), var(--orange));
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
    color:var(--red);
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

  .content-grid-activity-analytics{
    display:grid;
    grid-template-columns:1fr 2fr;
    gap:16px;
    margin-bottom:32px;
  }

  @media (max-width: 1024px){
    .content-grid{
      grid-template-columns:1fr;
    }
    
    .content-grid-activity-analytics{
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

  .search-box{
    display:flex;
    align-items:center;
    gap:8px;
    background:var(--field);
    border:1px solid var(--field-border);
    border-radius:8px;
    padding:8px 12px;
    transition:border-color .15s ease;
  }

  .search-box:focus-within{
    border-color:var(--red);
  }

  .search-box input{
    background:transparent;
    border:none;
    color:var(--text-hi);
    font-size:13px;
    font-family:inherit;
    outline:none;
    width:200px;
  }

  .search-box input::placeholder{
    color:var(--text-low);
  }

  .search-icon{
    color:var(--text-low);
    font-size:14px;
  }

  .card-title{
    font-family:'Space Grotesk', sans-serif;
    font-size:16px;
    font-weight:600;
    color:var(--text-hi);
  }

  .card-actions{
    display:flex;
    gap:8px;
  }

  .action-btn{
    padding:6px 12px;
    background:var(--field);
    border:1px solid var(--field-border);
    color:var(--text-mid);
    font-size:12px;
    font-weight:500;
    border-radius:6px;
    cursor:pointer;
    transition:all 0.15s ease;
    font-family:inherit;
  }

  .action-btn:hover{
    border-color:var(--text-low);
    background:#232426;
    color:var(--text-hi);
  }

  .action-btn.primary{
    background:var(--text-hi);
    color:var(--black);
    border-color:var(--text-hi);
  }

  .action-btn.primary:hover{
    background:#fff;
  }

  .table-container{
    overflow-x:auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
  }

  .table-container::-webkit-scrollbar{
    display: none; /* Chrome, Safari, Opera */
  }

  table{
    width:100%;
    border-collapse:collapse;
  }

  th{
    text-align:left;
    padding:12px 24px;
    font-size:12px;
    font-weight:500;
    color:var(--text-low);
    letter-spacing:0.02em;
    text-transform:uppercase;
    border-bottom:1px solid var(--panel-border);
  }

  td{
    padding:16px 24px;
    font-size:14px;
    color:var(--text-mid);
    border-bottom:1px solid var(--panel-border);
  }

  tr:last-child td{
    border-bottom:none;
  }

  tr:hover td{
    background:var(--field);
  }

  .status{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 10px;
    border-radius:12px;
    font-size:12px;
    font-weight:500;
  }

  .status.active{
    background:rgba(255,59,48,0.1);
    color:var(--red);
  }

  .status.inactive{
    background:var(--field);
    color:var(--text-low);
  }

  .status.pending{
    background:rgba(255,122,61,0.1);
    color:var(--orange);
  }

  .status.admin{
    background:rgba(255,59,48,0.1);
    color:var(--red);
  }

  .status.user{
    background:rgba(255,122,61,0.1);
    color:var(--orange);
  }

  .status-dot{
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
  }

  .activity-list{
    padding:0;
    list-style:none;
    max-height: 280px;
    overflow-y: auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
  }

  .activity-list::-webkit-scrollbar{
    display: none; /* Chrome, Safari, Opera */
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

  .notification-badge{
    position:absolute;
    top:-4px;
    right:-4px;
    background:var(--red);
    color:#fff;
    font-size:10px;
    font-weight:600;
    width:18px;
    height:18px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    animation:badgePop 0.3s ease;
  }

  @keyframes badgePop{
    0%{ transform:scale(0); }
    50%{ transform:scale(1.2); }
    100%{ transform:scale(1); }
  }

  .notification-panel{
    position:fixed;
    top:80px;
    right:32px;
    width:320px;
    background:var(--panel);
    border:1px solid var(--panel-border);
    border-radius:12px;
    padding:16px;
    z-index:100;
    display:none;
    box-shadow:0 20px 40px rgba(0,0,0,0.4);
  }

  .notification-panel.active{
    display:block;
    animation:slideIn 0.3s ease;
  }

  @keyframes slideIn{
    from{
      opacity:0;
      transform:translateY(-10px);
    }
    to{
      opacity:1;
      transform:translateY(0);
    }
  }

  .notification-item{
    display:flex;
    gap:12px;
    padding:12px;
    border-bottom:1px solid var(--panel-border);
    transition:background .15s ease;
  }

  .notification-item:hover{
    background:var(--field);
  }

  .notification-item:last-child{
    border-bottom:none;
  }

  .notification-icon{
    width:32px;
    height:32px;
    border-radius:8px;
    background:var(--field);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:14px;
    flex-shrink:0;
  }

  .notification-content{
    flex:1;
  }

  .notification-title{
    font-size:13px;
    font-weight:500;
    color:var(--text-hi);
    margin-bottom:2px;
  }

  .notification-time{
    font-size:11px;
    color:var(--text-low);
  }

  .notification-btn{
    position:relative;
    background:var(--field);
    border:1px solid var(--field-border);
    color:var(--text-mid);
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
    transition:all .15s ease;
    font-size:13px;
  }

  .notification-btn:hover{
    border-color:var(--text-low);
    color:var(--text-hi);
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
    
    .content-grid-activity-analytics{
      grid-template-columns:1fr;
    }
  }

  :focus-visible{
    outline:2px solid var(--red);
    outline-offset:2px;
  }

  @media (prefers-reduced-motion: reduce){
    .page-transition-in, .page-transition-out{
      animation:none;
    }
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
  }

  .modal table{
    font-size:13px;
  }

  .modal th{
    padding:8px 12px;
    font-size:11px;
  }

  .modal td{
    padding:10px 12px;
    font-size:12px;
  }

  .analytics-progress{
    height:8px;
    background:var(--field);
    border-radius:4px;
    overflow:hidden;
  }

  .analytics-progress-bar{
    height:100%;
    background:linear-gradient(90deg, var(--red), var(--orange));
    border-radius:4px;
    transition:width 0.3s ease;
  }
</style>
</head>
<body id="admin-page">

  <div class="dashboard-container">
    <div class="header">
      <div class="header-left">
        <h1 class="header-title">Admin Dashboard</h1>
      </div>
      <div class="header-right">
        <div class="live-time" id="live-time">--:--:--</div>
        <button class="notification-btn" id="notification-btn">
          🔔
          <span class="notification-badge">3</span>
        </button>
        <div class="notification-panel" id="notification-panel">
          <div class="notification-item">
            <div class="notification-icon">👤</div>
            <div class="notification-content">
              <div class="notification-title">New user registered</div>
              <div class="notification-time">2 minutes ago</div>
            </div>
          </div>
          <div class="notification-item">
            <div class="notification-icon">⚙️</div>
            <div class="notification-content">
              <div class="notification-title">System update completed</div>
              <div class="notification-time">1 hour ago</div>
            </div>
          </div>
          <div class="notification-item">
            <div class="notification-icon">🔒</div>
            <div class="notification-content">
              <div class="notification-title">Security scan finished</div>
              <div class="notification-time">3 hours ago</div>
            </div>
          </div>
        </div>
        <div class="user-menu">
          <div class="user-avatar">A</div>
          <span>Admin</span>
        </div>
        <button type="button" class="logout-btn" id="logout-btn">Logout</button>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Total Users</div>
        <div class="stat-value">{{ $users->count() + $admins->count() }}</div>
        <div class="stat-change positive">
          <span>{{ $admins->count() }} Admins</span>
          <span style="color:var(--text-low)">• {{ $users->count() }} Users</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Admins</div>
        <div class="stat-value">{{ $admins->count() }}</div>
        <div class="stat-change positive">
          <span>↑ New</span>
          <span style="color:var(--text-low)">administrators</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Regular Users</div>
        <div class="stat-value">{{ $users->count() }}</div>
        <div class="stat-change positive">
          <span>↑ Active</span>
          <span style="color:var(--text-low)">user accounts</span>
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

    <div class="content-grid full-width">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Admins ({{ $admins->count() }})</h2>
          <div class="card-actions">
            <div class="search-box">
              <span class="search-icon">🔍</span>
              <input type="text" placeholder="Search admins..." id="admin-search">
            </div>
            <button class="action-btn">Filter</button>
            <button class="action-btn primary" id="view-all-admins">View all</button>
          </div>
        </div>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Joined</th>
              </tr>
            </thead>
            <tbody id="admin-table-body">
              @forelse($admins as $admin)
                <tr class="admin-row" data-name="{{ $admin->name }}" data-email="{{ $admin->email }}">
                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->email }}</td>
                  <td><span class="status admin"><span class="status-dot"></span>Admin</span></td>
                  <td>{{ $admin->created_at->diffForHumans() }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" style="text-align: center; padding: 32px;">No admins found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Users ({{ $users->count() }})</h2>
          <div class="card-actions">
            <div class="search-box">
              <span class="search-icon">🔍</span>
              <input type="text" placeholder="Search users..." id="user-search">
            </div>
            <button class="action-btn">Filter</button>
            <button class="action-btn primary" id="view-all-users">View all</button>
          </div>
        </div>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Joined</th>
              </tr>
            </thead>
            <tbody id="user-table-body">
              @forelse($users as $user)
                <tr class="user-row" data-name="{{ $user->name }}" data-email="{{ $user->email }}">
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td><span class="status user"><span class="status-dot"></span>User</span></td>
                  <td>{{ $user->created_at->diffForHumans() }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" style="text-align: center; padding: 32px;">No users found</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="content-grid-activity-analytics">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title">Recent Activity</h2>
        </div>
        <ul class="activity-list" id="activity-feed">
          <li class="activity-item" style="animation: slideIn 0.3s ease">
            <div class="activity-icon">👤</div>
            <div class="activity-content">
              <div class="activity-title">New user registered</div>
              <div class="activity-time">2 minutes ago</div>
            </div>
          </li>
          <li class="activity-item" style="animation: slideIn 0.4s ease">
            <div class="activity-icon">⚙️</div>
            <div class="activity-content">
              <div class="activity-title">Settings updated</div>
              <div class="activity-time">15 minutes ago</div>
            </div>
          </li>
          <li class="activity-item" style="animation: slideIn 0.5s ease">
            <div class="activity-icon">🔒</div>
            <div class="activity-content">
              <div class="activity-title">Security scan completed</div>
              <div class="activity-time">1 hour ago</div>
            </div>
          </li>
          <li class="activity-item" style="animation: slideIn 0.6s ease">
            <div class="activity-icon">📊</div>
            <div class="activity-content">
              <div class="activity-title">Analytics report generated</div>
              <div class="activity-time">3 hours ago</div>
            </div>
          </li>
        </ul>
      </div>

      <div class="card">
        <div class="card-header">
          <h2 class="card-title">User Activity Analytics</h2>
        </div>
        <div style="padding: 24px;">
          <div style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
              <span style="font-size: 13px; color: var(--text-mid);">Daily Active Users</span>
              <span style="font-size: 13px; color: var(--text-hi); font-weight: 600;">{{ $users->count() }}</span>
            </div>
            <div class="analytics-progress">
              <div class="analytics-progress-bar" style="width: 75%;"></div>
            </div>
          </div>
          
          <div style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
              <span style="font-size: 13px; color: var(--text-mid);">Weekly Logins</span>
              <span style="font-size: 13px; color: var(--text-hi); font-weight: 600;">{{ $users->count() * 3 }}</span>
            </div>
            <div class="analytics-progress">
              <div class="analytics-progress-bar" style="width: 60%;"></div>
            </div>
          </div>
          
          <div style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
              <span style="font-size: 13px; color: var(--text-mid);">New Registrations (Week)</span>
              <span style="font-size: 13px; color: var(--text-hi); font-weight: 600;">{{ max(1, floor($users->count() / 3)) }}</span>
            </div>
            <div class="analytics-progress">
              <div class="analytics-progress-bar" style="width: 45%;"></div>
            </div>
          </div>
          
          <div style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
              <span style="font-size: 13px; color: var(--text-mid);">Admin Activity</span>
              <span style="font-size: 13px; color: var(--text-hi); font-weight: 600;">{{ $admins->count() }}</span>
            </div>
            <div class="analytics-progress">
              <div class="analytics-progress-bar" style="width: 30%;"></div>
            </div>
          </div>

          <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--panel-border);">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
              <div>
                <div style="font-size: 11px; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.02em; margin-bottom: 4px;">Peak Hours</div>
                <div style="font-size: 14px; color: var(--text-hi); font-weight: 500;">9AM - 12PM</div>
              </div>
              <div>
                <div style="font-size: 11px; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.02em; margin-bottom: 4px;">Avg Session</div>
                <div style="font-size: 14px; color: var(--text-hi); font-weight: 500;">24 min</div>
              </div>
              <div>
                <div style="font-size: 11px; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.02em; margin-bottom: 4px;">Most Active Day</div>
                <div style="font-size: 14px; color: var(--text-hi); font-weight: 500;">Monday</div>
              </div>
              <div>
                <div style="font-size: 11px; color: var(--text-low); text-transform: uppercase; letter-spacing: 0.02em; margin-bottom: 4px;">Growth Rate</div>
                <div style="font-size: 14px; color: var(--red); font-weight: 500;">+12.5%</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <footer style="margin-top: 48px; padding-top: 24px; border-top: 1px solid var(--panel-border); text-align: center;">
      <div style="font-size: 12px; color: var(--text-low); margin-bottom: 8px;">
        © {{ date('Y') }} Admin Dashboard. All rights reserved.
      </div>
      <div style="font-size: 11px; color: var(--text-low);">
        <span style="margin: 0 8px;">Version 1.0.0</span>
        <span style="margin: 0 8px;">•</span>
        <span style="margin: 0 8px;">Last updated: {{ now()->format('M d, Y') }}</span>
      </div>
    </footer>
  </div>

  <!-- Logout Confirmation Modal -->
  <div class="modal-overlay" id="logout-modal">
    <div class="modal">
      <div class="modal-icon">🔒</div>
      <h3 class="modal-title">Confirm Logout</h3>
      <p class="modal-message">Are you sure you want to log out? You will need to sign in again to access your account.</p>
      <div style="display: flex; gap: 12px; justify-content: center;">
        <button class="action-btn" id="cancel-logout">Cancel</button>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="action-btn primary">Logout</button>
        </form>
      </div>
    </div>
  </div>

  <!-- View All Admins Modal -->
  <div class="modal-overlay" id="view-all-admins-modal">
    <div class="modal" style="max-width: 600px; text-align: left;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h3 class="modal-title">All Admins ({{ $admins->count() }})</h3>
        <div style="display: flex; gap: 8px; align-items: center;">
          <a href="{{ route('signup') }}" class="action-btn primary" style="text-decoration: none; padding: 6px 12px;">Add New Admin</a>
          <button class="action-btn" id="close-admins-modal" style="padding: 4px 8px;">✕</button>
        </div>
      </div>
      <div class="table-container" style="max-height: 400px; overflow-y: auto;">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Joined</th>
            </tr>
          </thead>
          <tbody>
            @forelse($admins as $admin)
              <tr>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->created_at->diffForHumans() }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" style="text-align: center; padding: 32px;">No admins found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- View All Users Modal -->
  <div class="modal-overlay" id="view-all-users-modal">
    <div class="modal" style="max-width: 600px; text-align: left;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h3 class="modal-title">All Users ({{ $users->count() }})</h3>
        <div style="display: flex; gap: 8px; align-items: center;">
          <a href="{{ route('signup') }}" class="action-btn primary" style="text-decoration: none; padding: 6px 12px;">Add New User</a>
          <button class="action-btn" id="close-users-modal" style="padding: 4px 8px;">✕</button>
        </div>
      </div>
      <div class="table-container" style="max-height: 400px; overflow-y: auto;">
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Joined</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->diffForHumans() }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" style="text-align: center; padding: 32px;">No users found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const adminPage = document.getElementById('admin-page');
      const liveTime = document.getElementById('live-time');
      const notificationBtn = document.getElementById('notification-btn');
      const logoutBtn = document.getElementById('logout-btn');
      const logoutModal = document.getElementById('logout-modal');
      const cancelLogout = document.getElementById('cancel-logout');
      const notificationPanel = document.getElementById('notification-panel');
      const adminSearch = document.getElementById('admin-search');
      const userSearch = document.getElementById('user-search');
      const viewAllAdmins = document.getElementById('view-all-admins');
      const viewAllUsers = document.getElementById('view-all-users');
      const viewAllAdminsModal = document.getElementById('view-all-admins-modal');
      const viewAllUsersModal = document.getElementById('view-all-users-modal');
      const closeAdminsModal = document.getElementById('close-admins-modal');
      const closeUsersModal = document.getElementById('close-users-modal');
      
      if (adminPage) {
        adminPage.classList.add('page-transition-in');
      }
      
      // Live time display
      function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
          hour12: false, 
          hour: '2-digit', 
          minute: '2-digit', 
          second: '2-digit' 
        });
        if (liveTime) {
          liveTime.textContent = timeString;
        }
      }
      
      updateTime();
      setInterval(updateTime, 1000);
      
      // Logout confirmation modal
      if (logoutBtn && logoutModal) {
        logoutBtn.addEventListener('click', function(e) {
          e.preventDefault();
          logoutModal.classList.add('active');
        });
      }

      if (cancelLogout && logoutModal) {
        cancelLogout.addEventListener('click', function(e) {
          e.preventDefault();
          logoutModal.classList.remove('active');
        });
      }

      // Close modal when clicking outside
      if (logoutModal) {
        logoutModal.addEventListener('click', function(e) {
          if (e.target === logoutModal) {
            logoutModal.classList.remove('active');
          }
        });
      }

      // Notification panel toggle
      if (notificationBtn && notificationPanel) {
        notificationBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          notificationPanel.classList.toggle('active');
        });
        
        // Close panel when clicking outside
        document.addEventListener('click', function(e) {
          if (!notificationPanel.contains(e.target) && !notificationBtn.contains(e.target)) {
            notificationPanel.classList.remove('active');
          }
        });
      }
      
      // Search functionality for admin table
      if (adminSearch) {
        adminSearch.addEventListener('input', function() {
          const searchTerm = this.value.toLowerCase();
          const adminRows = document.querySelectorAll('.admin-row');
          
          adminRows.forEach(row => {
            const name = row.dataset.name.toLowerCase();
            const email = row.dataset.email.toLowerCase();
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });
        });
      }
      
      // Search functionality for user table
      if (userSearch) {
        userSearch.addEventListener('input', function() {
          const searchTerm = this.value.toLowerCase();
          const userRows = document.querySelectorAll('.user-row');
          
          userRows.forEach(row => {
            const name = row.dataset.name.toLowerCase();
            const email = row.dataset.email.toLowerCase();
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });
        });
      }
      
      // View all admins modal functionality
      if (viewAllAdmins && viewAllAdminsModal) {
        viewAllAdmins.addEventListener('click', function() {
          // Clear search and show all rows in main table
          if (adminSearch) {
            adminSearch.value = '';
          }
          const adminRows = document.querySelectorAll('.admin-row');
          adminRows.forEach(row => {
            row.style.display = '';
          });
          // Open modal
          viewAllAdminsModal.classList.add('active');
        });
      }

      if (closeAdminsModal && viewAllAdminsModal) {
        closeAdminsModal.addEventListener('click', function() {
          viewAllAdminsModal.classList.remove('active');
        });
      }

      if (viewAllAdminsModal) {
        viewAllAdminsModal.addEventListener('click', function(e) {
          if (e.target === viewAllAdminsModal) {
            viewAllAdminsModal.classList.remove('active');
          }
        });
      }
      
      // View all users modal functionality
      if (viewAllUsers && viewAllUsersModal) {
        viewAllUsers.addEventListener('click', function() {
          // Clear search and show all rows in main table
          if (userSearch) {
            userSearch.value = '';
          }
          const userRows = document.querySelectorAll('.user-row');
          userRows.forEach(row => {
            row.style.display = '';
          });
          // Open modal
          viewAllUsersModal.classList.add('active');
        });
      }

      if (closeUsersModal && viewAllUsersModal) {
        closeUsersModal.addEventListener('click', function() {
          viewAllUsersModal.classList.remove('active');
        });
      }

      if (viewAllUsersModal) {
        viewAllUsersModal.addEventListener('click', function(e) {
          if (e.target === viewAllUsersModal) {
            viewAllUsersModal.classList.remove('active');
          }
        });
      }
      
      // Animated counters for statistics
      function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
          } else {
            element.textContent = Math.floor(current);
          }
        }, 30);
      }
      
      // Animate stat values on load
      const statValues = document.querySelectorAll('.stat-value');
      statValues.forEach(stat => {
        const targetValue = parseInt(stat.textContent) || 0;
        if (targetValue > 0) {
          animateCounter(stat, targetValue);
        }
      });
      
      // Animate analytics progress bars on load
      const progressBars = document.querySelectorAll('.analytics-progress-bar');
      progressBars.forEach(bar => {
        const targetWidth = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
          bar.style.width = targetWidth;
        }, 500);
      });
      
      // Dynamic activity feed simulation
      const activityFeed = document.getElementById('activity-feed');
      if (activityFeed) {
        const activities = [
          { icon: '👤', title: 'New user registered', time: 'Just now' },
          { icon: '⚙️', title: 'System update available', time: 'Just now' },
          { icon: '🔒', title: 'Security alert resolved', time: 'Just now' },
          { icon: '📊', title: 'New report generated', time: 'Just now' },
          { icon: '💬', title: 'New support ticket', time: 'Just now' }
        ];
        
        // Add new activity randomly
        setInterval(() => {
          if (Math.random() > 0.7) { // 30% chance every 10 seconds
            const randomActivity = activities[Math.floor(Math.random() * activities.length)];
            const newItem = document.createElement('li');
            newItem.className = 'activity-item';
            newItem.style.animation = 'slideIn 0.3s ease';
            newItem.innerHTML = `
              <div class="activity-icon">${randomActivity.icon}</div>
              <div class="activity-content">
                <div class="activity-title">${randomActivity.title}</div>
                <div class="activity-time">${randomActivity.time}</div>
              </div>
            `;
            
            activityFeed.insertBefore(newItem, activityFeed.firstChild);
            
            // Keep only 5 items
            if (activityFeed.children.length > 5) {
              activityFeed.removeChild(activityFeed.lastChild);
            }
            
            // Update notification badge
            const badge = document.querySelector('.notification-badge');
            if (badge) {
              const currentCount = parseInt(badge.textContent);
              badge.textContent = currentCount + 1;
              badge.style.animation = 'none';
              setTimeout(() => badge.style.animation = 'badgePop 0.3s ease', 10);
            }
          }
        }, 10000);
      }
      
    });
  </script>

</body>
</html>