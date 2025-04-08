import { useEffect, useState } from "react";
import "./App.css";

function App() {
    const [mensaje, setMensaje] = useState("Cargando...");

    useEffect(() => {
        fetch("http://localhost:8000/api/prueba")
            .then((response) => response.json())
            .then((data) => setMensaje(data.mensaje))
            .catch((error) => {
                console.error("Error al conectar con la API:", error);
                setMensaje("Error al obtener datos");
            });
    }, []);

    return (
        <div className="App">
            <header className="App-header">
                <h1>Prueba de conexión con Laravel</h1>
                <p>{mensaje}</p>
            </header>
        </div>
    );
}

export default App;
