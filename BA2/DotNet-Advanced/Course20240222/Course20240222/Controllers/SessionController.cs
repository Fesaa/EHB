using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;

// For more information on enabling MVC for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace Course20240222.Controllers
{
    public class SessionController : Controller
    {
        private readonly string NAME_COOKIE_KEY = "_name";

        // GET: /<controller>/
        public IActionResult Index()
        {
            return View();
        }

        [HttpPost]
        public IActionResult Persist([FromForm]string name)
        {
            HttpContext.Session.SetString(NAME_COOKIE_KEY, name);

            ViewBag.Name = name;
            return View("Name");
        }

        public IActionResult Name()
        {
            ViewBag.Name = HttpContext.Session.GetString(NAME_COOKIE_KEY) ?? "no clue sowwy <3";
            return View();
        }
    }
}

