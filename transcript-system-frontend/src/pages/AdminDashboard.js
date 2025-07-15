import { useState, useEffect } from "react";
import { BarChart, PieChart, XAxis, YAxis, CartesianGrid, Tooltip, 
         Legend, Bar, Cell, ResponsiveContainer, Pie } from "recharts";

function ModernAdminDashboard() {
  const [stats, setStats] = useState(null);
  const [recentData, setRecentData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [refreshing, setRefreshing] = useState(false);
  const [showMenu, setShowMenu] = useState(false);
  const token = localStorage.getItem("token");

  const fetchDashboardData = async (isRefresh = false) => {
    try {
      if (isRefresh) setRefreshing(true);
      else setLoading(true);
      setError(null);
      
      const [statsResponse, recentResponse] = await Promise.all([
        fetch("http://127.0.0.1:8000/api/admin/dashboard-stats", {
          headers: { 
            Authorization: `Bearer ${token}`, 
            Accept: "application/json",
            "Content-Type": "application/json"
          },
        }),
        fetch("http://127.0.0.1:8000/api/admin/recent-data", {
          headers: { 
            Authorization: `Bearer ${token}`, 
            Accept: "application/json",
            "Content-Type": "application/json"
          },
        })
      ]);

      if (!statsResponse.ok || !recentResponse.ok) {
        throw new Error('Failed to fetch data');
      }

      const statsData = await statsResponse.json();
      const recentDataResponse = await recentResponse.json();

      setStats(statsData);
      setRecentData(recentDataResponse);
    } catch (error) {
      console.error("Failed to fetch dashboard data:", error);
      if (error.message.includes('401') || error.message.includes('Unauthorized')) {
        setError("Session expired. Please log in again.");
        localStorage.removeItem("token");
      } else {
        setError("Failed to load dashboard data. Please try again.");
      }
    } finally {
      setLoading(false);
      setRefreshing(false);
    }
  };

  useEffect(() => {
    if (token) {
      fetchDashboardData();
      // Auto-refresh every 5 minutes
      const interval = setInterval(() => fetchDashboardData(true), 5 * 60 * 1000);
      return () => clearInterval(interval);
    } else {
      setError("No authentication token found. Please log in.");
      setLoading(false);
    }
  }, [token]);

  const handleRefresh = () => {
    fetchDashboardData(true);
  };

  // Chart data preparation with new color scheme
  const chartData = stats ? [
    { name: 'Staff', value: stats.staffCount, color: '#1e293b' },
    { name: 'Students', value: stats.studentCount, color: '#0f172a' },
    { name: 'Courses', value: stats.courseCount, color: '#b91c1c' },
    { name: 'Transcripts', value: stats.transcriptCount, color: '#7c2d12' }
  ] : [];

  // Better pie chart data - showing academic personnel distribution
  const pieData = stats ? [
    { name: 'Students', value: stats.studentCount, fill: '#0f172a' },
    { name: 'Staff', value: stats.staffCount, fill: '#1e293b' },
    { name: 'Courses per Student', value: Math.round(stats.courseCount / stats.studentCount), fill: '#b91c1c' },
    { name: 'Transcripts per Student', value: Math.round(stats.transcriptCount / stats.studentCount), fill: '#7c2d12' }
  ] : [];

  // Alternative: Academic performance distribution
  const performanceData = recentData?.recentTranscripts ? 
    recentData.recentTranscripts.reduce((acc, transcript) => {
      const grade = transcript.grade.charAt(0); // Get first letter (A, B, C, etc.)
      acc[grade] = (acc[grade] || 0) + 1;
      return acc;
    }, {}) : {};

  const gradeDistributionData = Object.keys(performanceData).map(grade => ({
    name: `Grade ${grade}`,
    value: performanceData[grade],
    fill: grade === 'A' ? '#166534' : grade === 'B' ? '#1e293b' : grade === 'C' ? '#b91c1c' : '#7c2d12'
  }));

  // Use grade distribution if we have transcript data, otherwise use the ratio data
  const finalPieData = gradeDistributionData.length > 0 ? gradeDistributionData : pieData;

  const styles = {
    container: {
      minHeight: "100vh",
      background: "transparant",
      padding: "1rem"
    },
    card: {
      background: "rgba(255, 255, 255, 0.95)",
      backdropFilter: "blur(10px)",
      borderRadius: "1rem",
      padding: "1.5rem",
      boxShadow: "0 8px 32px rgba(30, 41, 59, 0.15)",
      border: "1px solid rgba(255, 255, 255, 0.3)",
      transition: "all 0.3s ease"
    },
    statCard: {
      background: "rgba(255, 255, 255, 0.95)",
      backdropFilter: "blur(10px)",
      borderRadius: "1rem",
      padding: "1.5rem",
      boxShadow: "0 8px 32px rgba(30, 41, 59, 0.15)",
      border: "1px solid rgba(255, 255, 255, 0.3)",
      transition: "all 0.3s ease",
      cursor: "pointer"
    },
    statCardHover: {
      transform: "translateY(-4px)",
      boxShadow: "0 12px 40px rgba(30, 41, 59, 0.25)"
    },
    button: {
      padding: "0.5rem 1rem",
      backgroundColor: "#f1f5f9",
      border: "1px solid #e2e8f0",
      borderRadius: "0.75rem",
      cursor: "pointer",
      transition: "all 0.2s ease",
      display: "flex",
      alignItems: "center",
      gap: "0.5rem",
      fontSize: "0.875rem",
      fontWeight: "500",
      color: "#334155"
    },
    primaryButton: {
      padding: "0.5rem 1rem",
      backgroundColor: "#1e293b",
      color: "white",
      border: "none",
      borderRadius: "0.75rem",
      cursor: "pointer",
      transition: "all 0.2s ease",
      fontSize: "0.875rem",
      fontWeight: "500"
    },
    icon: {
      width: "1.5rem",
      height: "1.5rem",
      display: "inline-flex",
      alignItems: "center",
      justifyContent: "center"
    },
    progressBar: {
      width: "100%",
      height: "0.5rem",
      backgroundColor: "#e2e8f0",
      borderRadius: "0.25rem",
      overflow: "hidden",
      marginTop: "1rem"
    },
    progressFill: {
      height: "100%",
      borderRadius: "0.25rem",
      transition: "width 1s ease",
      width: "75%"
    },
    table: {
      width: "100%",
      borderCollapse: "collapse"
    },
    tableHeader: {
      backgroundColor: "#f8fafc",
      padding: "0.75rem 1rem",
      textAlign: "left",
      fontSize: "0.75rem",
      fontWeight: "600",
      color: "#475569",
      textTransform: "uppercase",
      letterSpacing: "0.05em",
      borderBottom: "1px solid #e2e8f0"
    },
    tableCell: {
      padding: "1rem",
      borderBottom: "1px solid #e2e8f0"
    },
    tableRow: {
      transition: "background-color 0.2s ease"
    },
    badge: {
      padding: "0.25rem 0.5rem",
      fontSize: "0.75rem",
      fontWeight: "600",
      borderRadius: "9999px",
      display: "inline-flex",
      alignItems: "center"
    },
    avatar: {
      width: "2rem",
      height: "2rem",
      borderRadius: "50%",
      display: "flex",
      alignItems: "center",
      justifyContent: "center",
      color: "white",
      fontSize: "0.875rem",
      fontWeight: "600"
    },
    menu: {
      position: "absolute",
      right: "0",
      top: "3rem",
      backgroundColor: "white",
      borderRadius: "0.75rem",
      boxShadow: "0 10px 25px rgba(30, 41, 59, 0.2)",
      border: "1px solid #e2e8f0",
      padding: "0.5rem 0",
      zIndex: 10,
      minWidth: "12rem"
    },
    menuItem: {
      width: "100%",
      padding: "0.5rem 1rem",
      border: "none",
      background: "none",
      textAlign: "left",
      cursor: "pointer",
      transition: "background-color 0.2s ease",
      display: "flex",
      alignItems: "center",
      gap: "0.5rem",
      fontSize: "0.875rem",
      color: "#334155"
    }
  };

  // Simple SVG icons as React components
  const Icons = {
    Users: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
      </svg>
    ),
    BookOpen: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
      </svg>
    ),
    ClipboardList: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
      </svg>
    ),
    FileText: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
    ),
    RefreshCw: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
      </svg>
    ),
    MoreVertical: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
      </svg>
    ),
    TrendingUp: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
      </svg>
    ),
    BarChart3: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
    ),
    Download: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
      </svg>
    ),
    Bell: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 17h5l-5 5v-5zM4.868 12.354C4.305 11.222 4 9.962 4 8.5 4 5.186 6.686 2.5 10 2.5s6 2.686 6 6c0 1.462-.305 2.722-.868 3.854M6.339 15.177C7.189 15.683 8.175 16 9.238 16c3.314 0 6-2.686 6-6" />
      </svg>
    ),
    Calendar: () => (
      <svg style={styles.icon} fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
    )
  };

  if (loading) {
    return (
      <div style={styles.container}>
        <div style={{ maxWidth: "87.5rem", margin: "0 auto" }}>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit, minmax(250px, 1fr))", gap: "1.5rem", marginBottom: "2rem" }}>
            {[1, 2, 3, 4].map(i => (
              <div key={i} style={{
                ...styles.card,
                height: "120px",
                background: "linear-gradient(90deg, #f3f4f6 25%, rgba(255,255,255,0.5) 37%, #f3f4f6 63%)",
                backgroundSize: "400% 100%",
                animation: "shimmer 1.5s ease-in-out infinite"
              }}>
                <style>
                  {`
                    @keyframes shimmer {
                      0% { background-position: 100% 0; }
                      100% { background-position: -100% 0; }
                    }
                  `}
                </style>
              </div>
            ))}
          </div>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div style={{
        ...styles.container,
        display: "flex",
        alignItems: "center",
        justifyContent: "center"
      }}>
        <div style={{
          ...styles.card,
          maxWidth: "24rem",
          textAlign: "center"
        }}>
          <div style={{ color: "#ef4444", marginBottom: "1rem" }}>
            <Icons.FileText />
            <h2 style={{ fontSize: "1.25rem", fontWeight: "bold", margin: "0.5rem 0" }}>Dashboard Error</h2>
            <p style={{ color: "#6b7280", margin: "0.5rem 0" }}>{error}</p>
            <button 
              onClick={() => window.location.reload()} 
              style={{
                ...styles.primaryButton,
                marginTop: "1rem"
              }}
            >
              Retry
            </button>
          </div>
        </div>
      </div>
    );
  }

  const statCards = [
    { 
      label: "Total Staff", 
      value: stats?.staffCount || 0, 
      color: "#1e293b", 
      bgColor: "#f1f5f9",
      icon: <Icons.Users />,
      change: "+12%",
      changeColor: "#166534"
    },
    { 
      label: "Total Students", 
      value: stats?.studentCount || 0, 
      color: "#0f172a", 
      bgColor: "#f8fafc",
      icon: <Icons.BookOpen />,
      change: "+8%",
      changeColor: "#166534"
    },
    { 
      label: "Total Courses", 
      value: stats?.courseCount || 0, 
      color: "#b91c1c", 
      bgColor: "#fef2f2",
      icon: <Icons.ClipboardList />,
      change: "+5%",
      changeColor: "#166534"
    },
    { 
      label: "Transcripts Issued", 
      value: stats?.transcriptCount || 0, 
      color: "#7c2d12", 
      bgColor: "#fef7ed",
      icon: <Icons.FileText />,
      change: "+23%",
      changeColor: "#166534"
    }
  ];

  const formatDate = (dateString) => {
    return new Intl.DateTimeFormat('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    }).format(new Date(dateString));
  };

  const getGradeBadgeStyle = (grade) => {
    let bgColor, textColor;
    if (grade.startsWith('A')) {
      bgColor = "#f0fdf4";
      textColor = "#166534";
    } else if (grade.startsWith('B')) {
      bgColor = "#f1f5f9";
      textColor = "#1e293b";
    } else if (grade.startsWith('C')) {
      bgColor = "#fef2f2";
      textColor = "#b91c1c";
    } else {
      bgColor = "#fef7ed";
      textColor = "#7c2d12";
    }
    return { ...styles.badge, backgroundColor: bgColor, color: textColor };
  };

  return (
    <div style={styles.container}>
      <div style={{ maxWidth: "87.5rem", margin: "0 auto" }}>
        
        {/* Header */}
        <div style={{
          ...styles.card,
          marginBottom: "2rem",
          display: "flex",
          flexDirection: "row",
          justifyContent: "space-between",
          alignItems: "center",
          flexWrap: "wrap",
          gap: "1rem"
        }}>
          <div style={{ display: "flex", alignItems: "center", gap: "1rem" }}>
            <div style={{
              backgroundColor: "#1e293b",
              borderRadius: "0.75rem",
              padding: "0.75rem",
              color: "white"
            }}>
              <Icons.BarChart3 />
            </div>
            <div>
              <h1 style={{ fontSize: "2rem", fontWeight: "bold", color: "#0f172a", margin: 0 }}>
                Admin Dashboard
              </h1>
              <p style={{ color: "#475569", margin: "0.25rem 0 0 0" }}>
                Welcome back! Here's what's happening at your institution.
              </p>
            </div>
          </div>
          
          <div style={{ display: "flex", alignItems: "center", gap: "0.5rem" }}>
            <button 
              onClick={handleRefresh} 
              disabled={refreshing}
              style={{
                ...styles.button,
                opacity: refreshing ? 0.5 : 1
              }}
              onMouseEnter={(e) => e.target.style.backgroundColor = "#e2e8f0"}
              onMouseLeave={(e) => e.target.style.backgroundColor = "#f1f5f9"}
            >
              <div style={{
                ...styles.icon,
                animation: refreshing ? "spin 1s linear infinite" : "none"
              }}>
                <Icons.RefreshCw />
              </div>
              {refreshing ? 'Refreshing...' : 'Refresh'}
            </button>
            
            <div style={{ position: "relative" }}>
              <button 
                onClick={() => setShowMenu(!showMenu)}
                style={styles.button}
                onMouseEnter={(e) => e.target.style.backgroundColor = "#e5e7eb"}
                onMouseLeave={(e) => e.target.style.backgroundColor = "#f3f4f6"}
              >
                <Icons.MoreVertical />
              </button>
              {showMenu && (
                <div style={styles.menu}>
                  <button 
                    style={styles.menuItem}
                    onMouseEnter={(e) => e.target.style.backgroundColor = "#f9fafb"}
                    onMouseLeave={(e) => e.target.style.backgroundColor = "transparent"}
                  >
                    <Icons.Download /> Export Data
                  </button>
                  <button 
                    style={styles.menuItem}
                    onMouseEnter={(e) => e.target.style.backgroundColor = "#f9fafb"}
                    onMouseLeave={(e) => e.target.style.backgroundColor = "transparent"}
                  >
                    <Icons.Bell /> Notifications
                  </button>
                  <button 
                    style={styles.menuItem}
                    onMouseEnter={(e) => e.target.style.backgroundColor = "#f9fafb"}
                    onMouseLeave={(e) => e.target.style.backgroundColor = "transparent"}
                  >
                    <Icons.Calendar /> Schedule
                  </button>
                </div>
              )}
            </div>
          </div>
        </div>

        {/* Stats Cards */}
        <div style={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fit, minmax(250px, 1fr))",
          gap: "1.5rem",
          marginBottom: "2rem"
        }}>
          {statCards.map((item, index) => (
            <div 
              key={index}
              style={styles.statCard}
              onMouseEnter={(e) => {
                e.currentTarget.style.transform = "translateY(-4px)";
                e.currentTarget.style.boxShadow = "0 12px 40px rgba(0, 0, 0, 0.15)";
              }}
              onMouseLeave={(e) => {
                e.currentTarget.style.transform = "translateY(0)";
                e.currentTarget.style.boxShadow = "0 8px 32px rgba(0, 0, 0, 0.1)";
              }}
            >
              <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", marginBottom: "1rem" }}>
                <div style={{
                  backgroundColor: item.bgColor,
                  borderRadius: "0.75rem",
                  padding: "0.75rem",
                  color: item.color
                }}>
                  {item.icon}
                </div>
                <span style={{
                  fontSize: "0.875rem",
                  fontWeight: "600",
                  padding: "0.25rem 0.5rem",
                  borderRadius: "9999px",
                  backgroundColor: "#f0fdf4",
                  color: item.changeColor
                }}>
                  {item.change}
                </span>
              </div>
              
              <h3 style={{
                fontSize: "2rem",
                fontWeight: "bold",
                color: "#0f172a",
                margin: "0 0 0.5rem 0"
              }}>
                {item.value.toLocaleString()}
              </h3>
              <p style={{ color: "#475569", fontWeight: "500", margin: 0 }}>{item.label}</p>
              
              <div style={styles.progressBar}>
                <div 
                  style={{
                    ...styles.progressFill,
                    backgroundColor: item.color
                  }}
                ></div>
              </div>
            </div>
          ))}
        </div>

        {/* Charts Section */}
        <div style={{
          display: "grid",
          gridTemplateColumns: "2fr 1fr",
          gap: "1.5rem",
          marginBottom: "2rem"
        }}>
          
          {/* Bar Chart */}
          <div style={{ ...styles.card, height: "400px" }}>
            <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", marginBottom: "1.5rem" }}>
              <div>
                <h2 style={{ fontSize: "1.25rem", fontWeight: "bold", color: "#0f172a", margin: 0 }}>
                  System Overview
                </h2>
                <p style={{ color: "#475569", margin: "0.25rem 0 0 0" }}>
                  Current statistics across all modules
                </p>
              </div>
              <div style={{ color: "#166534" }}>
                <Icons.TrendingUp />
              </div>
            </div>
            
            <div style={{ height: "280px" }}>
              <ResponsiveContainer width="100%" height="100%">
                <BarChart data={chartData}>
                  <CartesianGrid strokeDasharray="3 3" stroke="#e2e8f0" />
                  <XAxis dataKey="name" stroke="#475569" />
                  <YAxis stroke="#475569" />
                  <Tooltip 
                    contentStyle={{
                      backgroundColor: "rgba(255, 255, 255, 0.95)",
                      border: "none",
                      borderRadius: "12px",
                      boxShadow: "0 8px 32px rgba(0, 0, 0, 0.1)"
                    }}
                  />
                  <Bar dataKey="value" radius={[4, 4, 0, 0]}>
                    {chartData.map((entry, index) => (
                      <Cell key={`cell-${index}`} fill={entry.color} />
                    ))}
                  </Bar>
                </BarChart>
              </ResponsiveContainer>
            </div>
          </div>

          {/* Pie Chart */}
          <div style={{ ...styles.card, height: "400px" }}>
            <h2 style={{ fontSize: "1.25rem", fontWeight: "bold", color: "#0f172a", margin: "0 0 0.5rem 0" }}>
              {gradeDistributionData.length > 0 ? "Grade Distribution" : "Academic Ratios"}
            </h2>
            <p style={{ color: "#475569", margin: "0 0 1.5rem 0", fontSize: "0.875rem" }}>
              {gradeDistributionData.length > 0 
                ? "Distribution of recent grades" 
                : "Academic metrics per student"}
            </p>
            
            <div style={{ height: "280px" }}>
              <ResponsiveContainer width="100%" height="100%">
                <PieChart>
                  <Pie
                    data={finalPieData}
                    cx="50%"
                    cy="50%"
                    labelLine={false}
                    label={({ name, percent }) => `${name} ${(percent * 100).toFixed(0)}%`}
                    outerRadius={80}
                    fill="#8884d8"
                    dataKey="value"
                  >
                    {finalPieData.map((entry, index) => (
                      <Cell key={`cell-${index}`} fill={entry.fill} />
                    ))}
                  </Pie>
                  <Tooltip />
                  <Legend />
                </PieChart>
              </ResponsiveContainer>
            </div>
          </div>
        </div>

        {/* Recent Data Tables */}
        <div style={{
          display: "grid",
          gridTemplateColumns: "1fr 1fr",
          gap: "1.5rem",
          marginBottom: "2rem"
        }}>
          
          {/* Recent Staff */}
          <div style={{
            ...styles.card,
            padding: 0,
            overflow: "hidden"
          }}>
            <div style={{ padding: "1.5rem", borderBottom: "1px solid #f3f4f6" }}>
              <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between" }}>
                <div>
                  <h2 style={{ fontSize: "1.25rem", fontWeight: "bold", color: "#0f172a", margin: 0 }}>
                    Recent Staff
                  </h2>
                  <p style={{ color: "#475569", margin: "0.25rem 0 0 0" }}>
                    Latest staff members added
                  </p>
                </div>
                <div style={{ color: "#1e293b" }}>
                  <Icons.Users />
                </div>
              </div>
            </div>
            
            <div style={{ overflowX: "auto" }}>
              <table style={styles.table}>
                <thead>
                  <tr>
                    <th style={styles.tableHeader}>Email</th>
                    <th style={styles.tableHeader}>Created</th>
                    <th style={styles.tableHeader}>Status</th>
                  </tr>
                </thead>
                <tbody>
                  {recentData?.recentStaff?.length > 0 ? (
                    recentData.recentStaff.map((staff) => (
                      <tr 
                        key={staff.id} 
                        style={styles.tableRow}
                        onMouseEnter={(e) => e.currentTarget.style.backgroundColor = "#f9fafb"}
                        onMouseLeave={(e) => e.currentTarget.style.backgroundColor = "transparent"}
                      >
                        <td style={styles.tableCell}>
                          <div style={{ display: "flex", alignItems: "center", gap: "0.75rem" }}>
                            <div style={{
                              ...styles.avatar,
                              backgroundColor: "#1e293b"
                            }}>
                              {staff.email.charAt(0).toUpperCase()}
                            </div>
                            <span style={{ fontSize: "0.875rem", fontWeight: "500", color: "#0f172a" }}>
                              {staff.email}
                            </span>
                          </div>
                        </td>
                        <td style={styles.tableCell}>
                          <span style={{ fontSize: "0.875rem", color: "#6b7280" }}>
                            {formatDate(staff.created_at)}
                          </span>
                        </td>
                        <td style={styles.tableCell}>
                          <span style={{
                            ...styles.badge,
                            backgroundColor: "#dcfce7",
                            color: "#166534"
                          }}>
                            Active
                          </span>
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan={3} style={{
                        ...styles.tableCell,
                        textAlign: "center",
                        padding: "2rem",
                        color: "#6b7280"
                      }}>
                        No recent staff registrations
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>

          {/* Recent Transcripts */}
          <div style={{
            ...styles.card,
            padding: 0,
            overflow: "hidden"
          }}>
            <div style={{ padding: "1.5rem", borderBottom: "1px solid #f3f4f6" }}>
              <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between" }}>
                <div>
                  <h2 style={{ fontSize: "1.25rem", fontWeight: "bold", color: "#111827", margin: 0 }}>
                    Recent Transcripts
                  </h2>
                  <p style={{ color: "#6b7280", margin: "0.25rem 0 0 0" }}>
                    Latest academic records
                  </p>
                </div>
                <div style={{ color: "#f59e0b" }}>
                  <Icons.FileText />
                </div>
              </div>
            </div>
            
            <div style={{ overflowX: "auto" }}>
              <table style={styles.table}>
                <thead>
                  <tr>
                    <th style={styles.tableHeader}>Student</th>
                    <th style={styles.tableHeader}>Grade</th>
                    <th style={styles.tableHeader}>Date</th>
                  </tr>
                </thead>
                <tbody>
                  {recentData?.recentTranscripts?.length > 0 ? (
                    recentData.recentTranscripts.slice(0, 5).map((transcript) => (
                      <tr 
                        key={transcript.id} 
                        style={styles.tableRow}
                        onMouseEnter={(e) => e.currentTarget.style.backgroundColor = "#f9fafb"}
                        onMouseLeave={(e) => e.currentTarget.style.backgroundColor = "transparent"}
                      >
                        <td style={styles.tableCell}>
                          <div>
                            <div style={{ fontSize: "0.875rem", fontWeight: "500", color: "#111827" }}>
                              {transcript.student?.name || "Unknown"}
                            </div>
                            <div style={{ fontSize: "0.75rem", color: "#6b7280" }}>
                              ID: {transcript.student?.student_number}
                            </div>
                          </div>
                        </td>
                        <td style={styles.tableCell}>
                          <span style={getGradeBadgeStyle(transcript.grade)}>
                            {transcript.grade}
                          </span>
                        </td>
                        <td style={styles.tableCell}>
                          <span style={{ fontSize: "0.875rem", color: "#6b7280" }}>
                            {formatDate(transcript.created_at)}
                          </span>
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan={3} style={{
                        ...styles.tableCell,
                        textAlign: "center",
                        padding: "2rem",
                        color: "#6b7280"
                      }}>
                        No recent transcripts
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {/* Footer */}
        <div style={{
          ...styles.card,
          textAlign: "center",
          padding: "1rem"
        }}>
          <p style={{ color: "#6b7280", fontSize: "0.875rem", margin: 0 }}>
            Last updated: {new Date().toLocaleString()} • Auto-refresh enabled every 5 minutes
          </p>
        </div>

        {/* Add CSS animations */}
        <style>
          {`
            @keyframes spin {
              from { transform: rotate(0deg); }
              to { transform: rotate(360deg); }
            }
            @keyframes shimmer {
              0% { background-position: 100% 0; }
              100% { background-position: -100% 0; }
            }
            @media (max-width: 768px) {
              .charts-grid {
                grid-template-columns: 1fr !important;
              }
              .tables-grid {
                grid-template-columns: 1fr !important;
              }
            }
          `}
        </style>
      </div>
    </div>
  );
}

export default ModernAdminDashboard;