using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;

namespace Course20240222.Controllers
{
    public class RegistreerController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public void Register([FromForm]string email, [FromForm] string client, [FromForm] string password)
        {
            Console.WriteLine($"Email: {email}, Client: {client}; Password: {password}");
        }
    }
}

