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
                    <h1 class="text-2xl font-semibold ml-4">View Users</h1>
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
                      <!-- Export & Row Control Bar -->
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
                        
                       <div id="user-table"></div>
                       
                    </div>
                </div>
            </main>

            <!-- Footer -->
           @include('layouts.footer')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
     <script>
        document.addEventListener('DOMContentLoaded', () => {
    const users = @json($users);

    let grid = new gridjs.Grid({
        columns: [
            { name: 'S.No', width: '80px' },
            { name: 'Username', width: '140px' },
            { name: 'Usertype', width: '120px' },
            { name: 'Actions', width: '120px' },
        ],
        data: users.map((user, index) => [
            index + 1,
            user.username,
            user.usertype,
            gridjs.html(`
               
                <button class="delete-btn text-red-600 ml-2" data-id="${user.id}">
                    <i class="ri-delete-bin-line"></i>
                </button>
            `)
        ]),
        search: true,
        pagination: { enabled: true, limit: 10 },
        sort: true,
        resizable: true,
        className: {
            table: "min-w-full border rounded overflow-hidden",
            td: "px-4 py-2",
            th: "bg-gray-100 px-4 py-2"
        }
    }).render(document.getElementById("user-table"));

   document.addEventListener("click", function (e) {
    if (e.target.closest(".delete-btn")) {
        let btn = e.target.closest(".delete-btn");
        let userId = btn.dataset.id;

        Swal.fire({
            title: "Are you sure?",
            text: "This user will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/delete-user/${userId}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                }).then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Remove the row dynamically
                        btn.closest("tr").remove();

                        Swal.fire("Deleted!", "User has been deleted.", "success");
                    } else {
                        Swal.fire("Error!", "Failed to delete user.", "error");
                    }
                }).catch(() => {
                    Swal.fire("Error!", "Something went wrong.", "error");
                });
            }
        });
    }

});


    document.getElementById("rowsPerPage").addEventListener("change", function() {
        let limit = parseInt(this.value);
        grid.updateConfig({
            pagination: { enabled: true, limit: limit }
        }).forceRender();
    });

    // 🔹 Export functions
    function getTableData() {
        return users.map((user, i) => [
            i + 1,
            user.username,
            user.usertype,
            user.created_at,
        ]);
    }

    document.getElementById("copyBtn").addEventListener("click", () => {
        navigator.clipboard.writeText(getTableData().map(r => r.join("\t")).join("\n"));
        alert("Copied to clipboard!");
    });

    document.getElementById("csvBtn").addEventListener("click", () => {
        let csvContent = "data:text/csv;charset=utf-8," +
            ["S.No,Username,Usertype,Added On", ...getTableData().map(r => r.join(","))].join("\n");
        let link = document.createElement("a");
        link.setAttribute("href", encodeURI(csvContent));
        link.setAttribute("download", "users.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    document.getElementById("excelBtn").addEventListener("click", () => {
        let wb = XLSX.utils.book_new();
        let ws = XLSX.utils.aoa_to_sheet([["S.No","Username","Usertype","Added On"], ...getTableData()]);
        XLSX.utils.book_append_sheet(wb, ws, "Users");
        XLSX.writeFile(wb, "users.xlsx");
    });

    document.getElementById("pdfBtn").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF("p", "pt", "a4"); // Portrait mode l for landscape

    const totalPagesExp = "{total_pages_count_string}";

    doc.autoTable({
        head: [["S.No", "Username", "Usertype", "Added On"]],
        body: users.map((user, index) => [
            index + 1,
            user.username,
            user.usertype,
            user.created_at
        ]),
        styles: {
            fontSize: 9,
            cellPadding: 5,
            overflow: "linebreak" // word wrap
        },
        columnStyles: {
            0: { cellWidth: 40 },   // S.No
            1: { cellWidth: 120 },  // Username
            2: { cellWidth: 90 },   // Usertype
            3: { cellWidth: 150 },  // Added On
        },
        didDrawPage: function (data) {
            //  Title at the top
            doc.setFontSize(14);
            doc.setFont("helvetica", "bold");
            doc.text("Users List", data.settings.margin.left, 30);

            // Footer with page numbers
            let pageCount = doc.internal.getNumberOfPages();
            let str = "Page " + doc.internal.getCurrentPageInfo().pageNumber;
            if (typeof doc.putTotalPages === "function") {
                str = str + " of " + totalPagesExp;
            }
            doc.setFontSize(9);
            doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 10);
        },
        margin: { top: 50 } 
    });

    if (typeof doc.putTotalPages === "function") {
        doc.putTotalPages(totalPagesExp);
    }

    doc.save("users.pdf");
});
    document.getElementById("printBtn").addEventListener("click", () => {
        let printWindow = window.open("", "_blank");
        printWindow.document.write("<h2>Users List</h2>");
        printWindow.document.write("<table border='1' cellspacing='0' cellpadding='5'>");
        printWindow.document.write("<tr><th>S.No</th><th>Username</th><th>Usertype</th></tr>");
        getTableData().forEach(r => {
            printWindow.document.write("<tr>" + r.map(c => `<td>${c}</td>`).join("") + "</tr>");
        });
        printWindow.document.write("</table>");
        printWindow.document.close();
        printWindow.print();
    });
});
    </script>
    </script>
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
   </body>
</html>
