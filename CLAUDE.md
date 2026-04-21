# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**SISAPONE** is a legacy monolithic PHP business application for Vicencio (a Chilean retail company). It handles sales reporting, inventory management, DSM validation, and integrates with SAP via SQL Server. There is no framework — it is plain PHP with inline HTML/SQL/JS.

A full rewrite is underway at `c:/laragon/www/sisap` (Laravel 13 + Inertia + Vue + Tailwind).

## Running the app

Served via Laragon (local Apache). Access at `http://sisapone.test` or `http://localhost/sisapone`. No build step — PHP is interpreted directly.

## Architecture

### Request flow

```
index.php → temas/minimalplomo/index.php → clases/modulos.php (switch on ?opc=)
                                         → clases/menu.php (renders sidebar)
```

All navigation is `index.php?opc=<key>`. The `modulos.php` class has ~537 `case` statements, each doing a bare `include` of the matching module file from `/modulos/`.

### Key classes

| File | Role |
|------|------|
| `clases/modulos.php` | Routing dispatcher — maps `?opc` values to module files |
| `clases/menu.php` | Generates role-based sidebar HTML |
| `clases/funciones.php` | Shared utility functions (RUT formatting, module lookups) |
| `clases/conexionocdb.php` | Primary DB connection — ODBC to SQL Server (DSN "prueba") |
| `clases/conexion_pdo.php` | Secondary PDO connection to `RP_VICENCIO` on 192.168.3.40 |
| `clases/registroLogs.php` | Writes daily text logs to `/logs/logDDMMYYYY.TXT` |

### Session variables (set at login by `modulos/sesion/doLogin.php`)

- `$_SESSION["usuario_rol"]` — role ID: 1=ROOT/admin, 2=Vendedor, 3=Vizador
- `$_SESSION["usuario_user"]`, `["usuario_nombre"]`, `["usuario_id"]`
- `$_SESSION["bodega"]` — warehouse assignment
- `$_SESSION["workstation"]` — workstation identifier

### Modules

Each directory under `/modulos/` is a feature area. Module files are standalone PHP files: they open their own DB connection, run raw SQL via `odbc_exec()`, and echo HTML + embedded JS directly. There is no separation of concerns.

```
modulos/
├── sesion/         # Login/logout
├── vendedor/       # Sales & inventory reports (largest module, ~50+ files)
├── cmando/         # Dashboard / command center
├── indicadores/    # Analytics
├── usuarios/       # User management
├── transferencias/ # Merchandise transfers
├── reportes/       # Report generation (FPDF for PDFs)
├── impresiones/    # Print/export
└── ...
```

### Adding a new module

1. Create `modulos/<area>/<name>.php`
2. Add a `case '<key>':` entry in `clases/modulos.php` pointing to it
3. Add the menu link in `clases/menu.php` under the appropriate role block

### Database

- Primary: SQL Server via ODBC — `odbc_connect("prueba", "sa", ...)` — most modules use this
- Secondary: PDO to SQL Server (`RP_VICENCIO`) — used in some newer modules
- There is also a legacy `clases/conexionMysql.php` (deprecated MySQL extension, effectively unused)
- All queries are raw SQL strings — no ORM

### Frontend libraries (manually included, no package manager at root)

- jQuery 1.8.2 + jQuery UI (datepicker, timepicker)
- DataTables 1.13.4
- SweetAlert2
- Chart.js 1.0.2 and AMCharts (dashboards)
- FPDF (server-side PDF generation)
- Font Awesome 6.3.0
