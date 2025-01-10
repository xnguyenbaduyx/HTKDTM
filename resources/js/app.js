import './bootstrap';
import { SupersetEmbedSDK } from '@superset-ui/embedded-sdk';

// Cấu hình SDK với domain Superset của bạn
SupersetEmbedSDK.init({
  supersetDomain: 'http://localhost:8088', // Thay bằng domain của Superset
});

// Nhúng một dashboard
SupersetEmbedSDK.embedDashboard({
  id: 'http://localhost:8088/superset/dashboard/6', // ID của dashboard cần nhúng
  mountPoint: document.getElementById('dashboard-container'), // Thẻ HTML nơi bạn muốn hiển thị dashboard
  fetchGuestToken: async () => {
    // Lấy Guest Token từ API Laravel
    const response = await fetch('/get-superset-token'); 
    return response.text();
  },
});