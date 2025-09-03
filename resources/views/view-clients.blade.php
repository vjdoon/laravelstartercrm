@include('layouts.header')
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
       @include('layouts.sidebar')
        <!-- Main Content Area -->
        <div id="main-content" class="main-content flex-1 ml-0 md:ml-64-desktop flex flex-col max-w-full">
            <!-- Top Header -->
            <header class="top-header bg-white dark:bg-gray-800 p-4 flex items-center justify-between shadow-md rounded-b-xl">
                <div class="flex items-center">
                    <button id="sidebar-toggle-btn" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
                        <i class="ri-menu-line text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-semibold ml-4">View Client</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center text-gray-600 dark:text-gray-300">
                        <i class="ri-dashboard-line mr-1"></i>
                        <span>Dashboard - CRM</span>
                    </div>
                <button id="theme-switch" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
                        <i class="ri-sun-line text-xl dark:hidden"></i>
                        <i class="ri-moon-line text-xl hidden dark:block"></i>
                    </button>

                    <div class="relative">
                        <img id="account-avatar" src="https://placehold.co/40x40/3B82F6/ffffff?text=U" alt="User Avatar" class="w-10 h-10 rounded-full cursor-pointer border-2 border-blue-500">
                        <div id="account-dropdown" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 hidden z-10">
                             <button id="openChangePasswordModal" type="button" 
    class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
           hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-md">
    <i class="ri-lock-line mr-2"></i> Change Password
</button>
                           <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-b-md">
        <i class="ri-logout-box-line mr-2"></i> Logout
    </button>
</form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Dashboard Content -->
              <main class="p-6 flex-grow">
                <div class="dashboard-card bg-white p-4 rounded-lg shadow-md mb-6">

                <!-- Export Buttons Row -->
<div class="flex justify-between items-center mb-4 flex-wrap gap-4">
  <div class="space-x-2">
    <button id="copyBtn" class="px-3 py-2 bg-blue-600 text-white rounded">Copy</button>
    <button id="excelBtn" class="px-3 py-2 bg-green-600 text-white rounded">Excel</button>
    <button id="csvBtn" class="px-3 py-2 bg-yellow-500 text-white rounded">CSV</button>
    <button id="pdfBtn" class="px-3 py-2 bg-red-600 text-white rounded">PDF</button>
    <button id="printBtn" class="px-3 py-2 bg-gray-600 text-white rounded">Print</button>
  </div>

  <!-- Rows per page -->
  <div>
    <label for="rowsPerPage" class="mr-2">Show</label>
    <select id="rowsPerPage" class="border rounded px-2 py-1">
      <option value="10" selected>10</option>
      <option value="25">25</option>
      <option value="50">50</option>
      <option value="100">100</option>
    </select>
    <span>entries</span>
  </div>
</div>
                    <div class="w-full overflow-x-auto">
                        
                       <div id="client-table"></div>
                      
                    </div>
                </div>
            </main>

            <!-- Footer -->
            @include('layouts.footer')

   <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

 <script>
       document.addEventListener('DOMContentLoaded', () => {
  const tableEl = document.getElementById("client-table");

  const grid = new gridjs.Grid({
    columns: [
      { name: 'S.No', width: '80px' },
      { name: 'Full Name', width: '140px' },
      { name: 'Phone', width: '120px' },
      { name: 'Email', width: '200px' },
      {
        name: 'Remarks', width: '200px',
        formatter: (cell) => gridjs.html(`<div style="white-space: normal;">${cell ?? ''}</div>`)
      },
      { name: 'Actions', width: '120px' },
    ],
    server: {
      url: '/view-clients',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },   // 👈 important
      then: data => data.map((client, index) => [
        index + 1,
        `${client.first_name} ${client.last_name}`,
        client.phone,
        client.email,
        client.remarks && client.remarks.length > 30 ? `${client.remarks.slice(0, 30)}...` : (client.remarks ?? ''),
        gridjs.html(`
          <button class="edit-btn text-blue-600" data-id="${client.id}">
            <i class="ri-pencil-line"></i>
          </button>
          <button class="delete-btn text-red-600 ml-2" data-id="${client.id}">
            <i class="ri-delete-bin-line"></i>
          </button>
        `)
      ])
    },
    search: true,
    pagination: { enabled: true, limit: 10 },
    sort: true,
    resizable: true,
    className: {
      table: "min-w-full border rounded overflow-hidden",
      td: "px-4 py-2",
      th: "bg-gray-100 px-4 py-2"
    }
  }).render(tableEl);

  // Rows per page selector
  document.getElementById("rowsPerPage").addEventListener("change", function () {
    const limit = parseInt(this.value, 10);
    grid.updateConfig({ pagination: { enabled: true, limit, page: 1 } }).forceRender();
  });

  document.addEventListener("click", function (e) {
    if (e.target.closest(".delete-btn")) {
      const clientId = e.target.closest(".delete-btn").dataset.id;

      Swal.fire({
        title: "Are you sure?",
        text: "This client will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (!result.isConfirmed) return;

        fetch(`/delete-client/${clientId}`, {
          method: "DELETE",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
          }
        })
        .then(async (res) => {
          // this prevents JSON parse errors
          const contentType = res.headers.get('content-type') || '';
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          if (!contentType.includes('application/json')) throw new Error('Non-JSON response');
          return res.json();
        })
        .then(data => {
          if (data.status === 'success') {
            Swal.fire("Deleted!", "Client has been deleted.", "success");
            grid.forceRender(); // AJAX refresh -> updates pagination
          } else {
            Swal.fire("Error!", data.message || "Failed to delete client.", "error");
          }
        })
        .catch(err => {
          console.error('Delete error:', err);
          Swal.fire("Error!", "Something went wrong. Please try again.", "error");
        });
      });
    }

    // Edit
    if (e.target.closest(".edit-btn")) {
      const clientId = e.target.closest(".edit-btn").dataset.id;
      window.location.href = `/edit-client/${clientId}`;
    }
  });

  
  // CSV Export
document.getElementById("csvBtn").addEventListener("click", () => {
  grid.export({ type: "csv", filename: "clients" });
});

// Excel Export
document.getElementById("excelBtn").addEventListener("click", async () => {
  const res = await fetch("/view-clients", { headers: { "Accept": "application/json" } });
  const data = await res.json();

  const ws = XLSX.utils.json_to_sheet(data);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Clients");
  XLSX.writeFile(wb, "clients.xlsx");
});

// PDF Export
document.getElementById("pdfBtn").addEventListener("click", async () => {
  const { jsPDF } = window.jspdf;
  const res = await fetch("/view-clients", { headers: { "Accept": "application/json" } });
  const data = await res.json();

  const doc = new jsPDF();

  doc.setFontSize(16);
  doc.text("Clients List", 14, 15);

  //custom column widths
  doc.autoTable({
    startY: 25,
    head: [["S.No", "Name", "Phone", "Email", "Remarks"]],
    body: data.map((c, i) => [
      i + 1,
      `${c.first_name} ${c.last_name}`,
      c.phone,
      c.email,
      c.remarks ?? ""
    ]),
    columnStyles: {
      0: { cellWidth: 10 },     // S.No
      1: { cellWidth: 50 },     // Name 
      2: { cellWidth: 30 },     // Phone
      3: { cellWidth: 50 },     // Email
      4: { cellWidth: 'auto' }, // Remarks 
    },
    didDrawPage: (data) => {
      let pageCount = doc.internal.getNumberOfPages();
      let pageSize = doc.internal.pageSize;
      let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
      let pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();

      
      let pageCurrent = doc.internal.getCurrentPageInfo().pageNumber;
      doc.setFontSize(10);
      doc.text(
        `Page ${pageCurrent} of ${pageCount}`,
        pageWidth / 2,
        pageHeight - 10,
        { align: "center" }
      );
    }
  });

  doc.save("clients.pdf");
});

// Copy Button
document.getElementById("copyBtn").addEventListener("click", async () => {
  const res = await fetch("/view-clients", { headers: { "Accept": "application/json" } });
  const data = await res.json();
  const text = data
    .map(c => `${c.first_name} ${c.last_name}\t${c.phone}\t${c.email}`)
    .join("\n");
  await navigator.clipboard.writeText(text);
  alert("Copied to clipboard!");
});

// Print Button
document.getElementById("printBtn").addEventListener("click", async () => {
  const res = await fetch("/view-clients", { headers: { "Accept": "application/json" } });
  const data = await res.json();
  let html = "<h2>Clients List</h2><table border='1' style='width:100%;border-collapse:collapse'><tr><th>#</th><th>Name</th><th>Phone</th><th>Email</th><th>Remarks</th></tr>";
  data.forEach((c, i) => {
    html += `<tr><td>${i + 1}</td><td>${c.first_name} ${c.last_name}</td><td>${c.phone}</td><td>${c.email}</td><td>${c.remarks ?? ""}</td></tr>`;
  });
  html += "</table>";

  const win = window.open("");
  win.document.write(html);
  win.print();
  win.close();
});
});
    </script>
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
   </body>
</html>
