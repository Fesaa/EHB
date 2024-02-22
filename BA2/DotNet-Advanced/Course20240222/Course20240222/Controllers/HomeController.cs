using System.Diagnostics;
using Microsoft.AspNetCore.Mvc;
using Course20240222.Models;

namespace Course20240222.Controllers;

public class HomeController : Controller
{
    private readonly ILogger<HomeController> _logger;

    private readonly string COUNT_COOKIE_KEY = "_Counter";

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

    public IActionResult Counter()
    {
        Int32 count = HttpContext.Session.GetInt32(COUNT_COOKIE_KEY) ?? 0;
        count++;
        HttpContext.Session.SetInt32(COUNT_COOKIE_KEY, count);

        ViewBag.Count = count;
        return View();
    }

    [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
    public IActionResult Error()
    {
        return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
    }
}

