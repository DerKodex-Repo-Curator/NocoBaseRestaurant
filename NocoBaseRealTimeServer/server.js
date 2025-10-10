import express from "express";
import http from "http";
import { Server } from "socket.io";
import cors from "cors";

const app = express();
app.use(cors());
app.use(express.json());

const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: "*", // อนุญาตทุก origin ชั่วคราว (ปรับเป็น domain จริงได้ภายหลัง)
  },
});

// ========== SOCKET.IO ==========
io.on("connection", (socket) => {
  console.log("Client connected:", socket.id);

  // ลูกค้าจะส่ง order_id ของตัวเองมาเพื่อ join room
  socket.on("join_order", (order_id) => {
    socket.join(`order_${order_id}`);
    console.log(`Client ${socket.id} joined room order_${order_id}`);
  });

  socket.on("disconnect", () => {
    console.log("Client disconnected:", socket.id);
  });
});

// ========== API สำหรับ Workflow จาก NocoBase ==========
app.post("/order-status-update", (req, res) => {
  const { order_id, status } = req.body;
  console.log("Received update:", { order_id, status });

  // ส่ง event ไปเฉพาะ room ของ order_id นั้น
  io.to(`order_${order_id}`).emit("order_status_changed", { order_id, status });

  res.json({ success: true });
});

const PORT = 3000;
server.listen(PORT, () => {
  console.log(`Socket.IO server running on port ${PORT}`);
});
