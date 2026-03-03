// import '../css/app.css';
// import './bootstrap';

// import { createInertiaApp } from '@inertiajs/react';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// import { createRoot } from 'react-dom/client';

// const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) =>
//         resolvePageComponent(
//             `./Pages/${name}.jsx`,
//             import.meta.glob('./Pages/**/*.jsx'),
//         ),
//     setup({ el, App, props }) {
//         const root = createRoot(el);

//         root.render(<App {...props} />);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });


import React, { useEffect, useState } from "react";
import axios from "axios";

const API = "http://127.0.0.1:8000/api";

function App() {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(false);

  const fetchTasks = async () => {
    const res = await axios.get(`${API}/tasks`);
    setTasks(res.data);
  };

  const createTask = async () => {
    setLoading(true);
    await axios.post(`${API}/tasks`);
    setLoading(false);
    fetchTasks();
  };

  useEffect(() => {
    fetchTasks();

    const interval = setInterval(() => {
      fetchTasks();
    }, 3000); // Poll every 3 seconds

    return () => clearInterval(interval);
  }, []);

  return (
    <div style={{ padding: "40px" }}>
      <h1>Background Task Manager</h1>

      <button onClick={createTask} disabled={loading}>
        {loading ? "Creating..." : "Create Heavy Task"}
      </button>

      <h2>Tasks</h2>

      <ul>
        {tasks.map((task) => (
          <li key={task.id}>
            <strong>ID:</strong> {task.id} <br />
            <strong>Status:</strong> {task.status}
            <hr />
          </li>
        ))}
      </ul>
    </div>
  );
}

export default App;
