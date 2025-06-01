<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Integral de Ventas</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        header {
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            color: #2c3e50;
        }

        header p {
            color: #777;
            font-size: 12px;
        }

        /* Botón de imprimir */
        .no-print {
            text-align: right;
            margin-bottom: 20px;
        }

        .no-print button {
            background: #2980b9;
            border: none;
            padding: 10px 15px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        /* Sección de gráficos */
        .chart-container {
            width: 80%;
            margin: 40px auto;
            position: relative;
            height: 300px;
            /* Altura fija para los gráficos */
        }

        /* Tabla de datos */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
            font-size: 14px;
        }

        table th,
        table td {
            padding: 12px 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #2c3e50;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        /* No imprimir el botón */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>Reporte Integral de Ventas</h1>
            <p>Fecha de generación: {{ date('d-m-Y') }}</p>
        </header>

        <!-- Botón para imprimir en PDF -->
        <div class="no-print">
            <button onclick="window.print()">Imprimir PDF</button>
        </div>

        <!-- Datos en tabla -->
        <table>
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente->nombre ?? 'Sin asignar' }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d-m-Y H:i:s') }}</td>
                        <td>${{ number_format($venta->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Gráfico: Ventas por Mes -->
        <div class="chart-container">
            <canvas id="ventasPorMes"></canvas>
        </div>

        <div class="chart-container" style="display: flex; gap: 0px;">
            <!-- Gráfico: Mejores Vendedores -->
            <div style="flex: 1; height: 300px;">
                <canvas id="mejoresVendedores"></canvas>
            </div>

            <!-- Gráfico: Clientes Top -->
            <div style="flex: 1; height: 300px;">
                <canvas id="clientesTop"></canvas>
            </div>
        </div>


        <footer>
            <p>&copy; {{ date('Y') }} - Mi Empresa - Todos los derechos reservados</p>
        </footer>
    </div>

    <!-- Incluir Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Convertir los datos PHP en JSON para JavaScript
        const ventasPorMesData = @json($ventasPorMes);
        const mejoresVendedoresData = @json($mejoresVendedores);
        const clientesTopData = @json($clientesTop);

        // Gráfico de Ventas por Mes (Barras)
        new Chart(document.getElementById("ventasPorMes"), {
            type: 'bar',
            data: {
                labels: Object.keys(ventasPorMesData),
                datasets: [{
                    label: "Ventas por Mes",
                    backgroundColor: "#3498db",
                    data: Object.values(ventasPorMesData)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Ventas por Mes'
                    }
                }
            }
        });

        // Gráfico de Mejores Vendedores (Pastel)
        new Chart(document.getElementById("mejoresVendedores"), {
            type: 'pie',
            data: {
                labels: Object.keys(mejoresVendedoresData),
                datasets: [{
                    label: "Mejores Vendedores",
                    backgroundColor: ["#e74c3c", "#2ecc71", "#f1c40f", "#9b59b6", "#34495e"],
                    data: Object.values(mejoresVendedoresData)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Mejores Vendedores'
                    }
                }
            }
        });

        // Gráfico de Clientes Top (Doughnut)
        new Chart(document.getElementById("clientesTop"), {
            type: 'doughnut',
            data: {
                labels: Object.keys(clientesTopData),
                datasets: [{
                    label: "Clientes Top",
                    backgroundColor: ["#8e44ad", "#34495e", "#e67e22", "#16a085", "#27ae60"],
                    data: Object.values(clientesTopData)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Clientes que Más Compran'
                    }
                }
            }
        });
    </script>
</body>

</html>
