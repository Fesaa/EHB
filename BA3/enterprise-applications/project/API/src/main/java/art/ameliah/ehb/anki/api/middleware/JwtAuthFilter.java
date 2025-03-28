package art.ameliah.ehb.anki.api.middleware;

import art.ameliah.ehb.anki.api.services.JwtService;
import jakarta.servlet.FilterChain;
import jakarta.servlet.ServletException;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import lombok.RequiredArgsConstructor;
import org.springframework.http.HttpHeaders;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.web.filter.OncePerRequestFilter;

import java.io.IOException;

@RequiredArgsConstructor
public class JwtAuthFilter extends OncePerRequestFilter {

    private final JwtService jwtService;

    @Override
    protected void doFilterInternal(HttpServletRequest request, HttpServletResponse response, FilterChain filterChain) throws ServletException, IOException {
        String header = request.getHeader(HttpHeaders.AUTHORIZATION);

        if (header == null) {
            filterChain.doFilter(request, response);
            return;
        }

        String[] authElements = header.split(" ");
        if (authElements.length != 2) {
            filterChain.doFilter(request, response);
            return;
        }

        try {
            SecurityContextHolder.getContext().setAuthentication(jwtService.validate(request, authElements[1]));
        } catch (RuntimeException e) {
            SecurityContextHolder.clearContext();
            throw e;
        }

        filterChain.doFilter(request, response);
    }
}
