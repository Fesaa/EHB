package main

import (
	"bufio"
	"context"
	"fmt"
	"os"

	"github.com/Azure/azure-sdk-for-go/sdk/ai/azopenai"
	"github.com/Azure/azure-sdk-for-go/sdk/azcore"
	"github.com/Azure/azure-sdk-for-go/sdk/azcore/to"
)

var (
	azureOpenAIKey      = os.Getenv("AOAI_API_KEY")
	modelDeployment     = os.Getenv("AOAI_COMPLETIONS_MODEL")
	azureOpenAIEndpoint = os.Getenv("AOAI_ENDPOINT")
)

func main() {

	if azureOpenAIKey == "" || modelDeployment == "" || azureOpenAIEndpoint == "" {
		fmt.Fprintf(os.Stderr, "Skipping example, environment variables missing\n")
		return
	}

	keyCredential := azcore.NewKeyCredential(azureOpenAIKey)
	client, err := azopenai.NewClientWithKeyCredential(azureOpenAIEndpoint, keyCredential, nil)
	if err != nil {
		panic(err)
	}

	scanner := bufio.NewScanner(os.Stdin)
	fmt.Print("Give your input>>>  ")
	for scanner.Scan() {
		text := scanner.Text()

		if text == "stop" {
			break
		}

		handleRequest(client, text)
		fmt.Print("Give your input>>>  ")
	}

	if err := scanner.Err(); err != nil {
		panic(err)
	}
}

func handleRequest(client *azopenai.Client, input string) {
	resp, err := client.GetCompletions(context.TODO(), azopenai.CompletionsOptions{
		Prompt:         []string{input},
		MaxTokens:      to.Ptr(int32(2048)),
		Temperature:    to.Ptr(float32(0.0)),
		DeploymentName: &modelDeployment,
	}, nil)

	if err != nil {
		fmt.Println(fmt.Sprintf("Could not complete request, %e", err))
		return
	}

	fmt.Println(fmt.Sprintf("\tGot %d choices!", len(resp.Choices)))
	for _, choice := range resp.Choices {
		t := choice.Text
		if t != nil {
			fmt.Println(fmt.Sprintf("\t %s", *t))
		}
	}

}
