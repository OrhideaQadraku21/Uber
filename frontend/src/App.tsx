import { useEffect, useState } from "react";
import axios from "axios";

function App() {
  const [data, setData] = useState<any>(null);
  const [error, setError] = useState("");

  useEffect(() => {
    axios.get(`${import.meta.env.VITE_API_URL}/api/health`)

      .then((res) => {
        setData(res.data);
      })
      .catch((err) => {
        setError(err.message);
      });
  }, []);

  return (
    <div style={{ padding: "20px" }}>
      <h1>MiniUber Frontend</h1>

      {error && <p style={{ color: "red" }}>Error: {error}</p>}

      <h2>Backend response:</h2>
      <pre>{data ? JSON.stringify(data, null, 2) : "Loading..."}</pre>
    </div>
  );
}

export default App;
