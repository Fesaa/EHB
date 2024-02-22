using System.Diagnostics;
using Microsoft.AspNetCore.Mvc;
using Course20240222_2.Models;
using System.Linq;

namespace Course20240222_2.Controllers;

public class HomeController : Controller
{
    private readonly ILogger<HomeController> _logger;

    public HomeController(ILogger<HomeController> logger)
    {
        _logger = logger;
    }

    public IActionResult Index()
    {
        return View();
    }

    public IActionResult Privacy()
    {
        return View();
    }

    public IActionResult Producten()
    {
        return View(Product.GetProducts().OrderBy(p => p.Category));
    }

    public IActionResult Openingsuren()
    {
        return View();
    }

    public IActionResult Contact()
    {
        return View();
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public IActionResult Contacteren(string email, string name, string inhoud)
    {
        Console.WriteLine($"Email {email}, Name: {name}, Inhoud {inhoud}");
        return Ok("Love you honey <3");
    }

    [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
    public IActionResult Error()
    {
        return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
    }
}

