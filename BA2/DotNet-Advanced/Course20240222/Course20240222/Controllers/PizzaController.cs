using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Course20240222.Models;
using Microsoft.AspNetCore.Mvc;

// For more information on enabling MVC for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace Course20240222.Controllers
{
    public class PizzaController : Controller
    {

        public IActionResult Bestellen()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public IActionResult Bestel([FromForm]PizzaModel pizzaModel)
        {
            if (!pizzaModel.IsValid())
            {
                return NotFound("You bitch!");
            }
            return View("Toon", pizzaModel);
        }
    }
}

